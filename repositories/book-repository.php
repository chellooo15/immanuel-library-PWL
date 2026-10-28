<?php
require_once __DIR__ . "/../config/database.php";

function getBooks($search, $categoryId, $currentPage, $perPage)
{
  global $pdo;

  $query = "select b.id, b.title, b.stock, c.name as category from books b
    left join categories c on b.category_id = c.id
    where b.title like :search
    and (:category_filter = '' or b.category_id = :category_id)
    Limit :limit offset :offset
    ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$search%",
    'category_filter' => $categoryId,
    'category_id' => $categoryId,
    'limit' => $perPage,
    'offset' => ($currentPage - 1) * $perPage
  ]);
  $books = $stmt->fetchAll();

  $query = "select ba.book_id, a.name from book_author ba
    left join authors a on ba.author_id = a.id
    ";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $bookAuthors = $stmt->fetchAll();

  foreach ($books as &$book) {
    $book["authors"] = [];
    foreach ($bookAuthors as $bookAuthor) {
      if ($bookAuthor["book_id"] == $book["id"]) {
        $book["authors"][] = $bookAuthor["name"];
      }
    }
  }

  return $books;
}

function getTotalBooks($search, $categoryId)
{
  global $pdo;

  $query = "select count(*) from books
    where title like :search
    and (:category_filter = '' or category_id = :category_id)
    ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$search%",
    'category_filter' => $categoryId,
    'category_id' => $categoryId
  ]);

  return $stmt->fetchColumn();
}

function getBook($id)
{
  global $pdo;
  $query = "select b.id, b.title, b.isbn, b.year, b.stock, b.category_id, b.description, c.name as category from books b left join categories c on b.category_id = c.id where b.id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['id' => $id]);
  $book = $stmt->fetch();
  if (!$book) {
    header("Location: index.php");
    exit;
  }
  $query = "select a.id, a.name from book_author ba left join authors a on ba.author_id = a.id where ba.book_id = :book_id";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['book_id' => $book['id']]);
  $bookAuthors = $stmt->fetchAll();
  $book['author_ids'] = array_column($bookAuthors, 'id');
  $book['authors'] = array_column($bookAuthors, 'name');
  return $book;
}

function isIsbnTaken($isbn, $ignoreBookId = 0)
{
  global $pdo;
  $query = "select count(*) from books where isbn = :isbn and id != :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['isbn' => $isbn, 'id' => $ignoreBookId]);
  return $stmt->fetchColumn() > 0;
}

