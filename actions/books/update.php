<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/book-validation.php";

session_start();

if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
  $id = $_POST['id'] ?? 0;
  $errors = validateBook($_POST, $id);

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = getBookRequest($_POST);
    header("Location: ../../pages/books/edit.php?id=" . $id);
    exit;
  }

  try {
    $pdo->beginTransaction();

    $data = getBookRequest($_POST);

    $query = "update books set title = :title, isbn = :isbn, year = :year, stock = :stock, category_id = :category_id, description = :description where id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      'title' => $data['title'],
      'isbn' => $data['isbn'],
      'year' => $data['year'],
      'stock' => $data['stock'],
      'category_id' => $data['category_id'],
      'description' => $data['description'],
      'id' => $id
    ]);

    $query = "delete from book_author where book_id = :book_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['book_id' => $id]);

    $query = "insert into book_author (book_id, author_id) values (:book_id, :author_id)";
    $stmt = $pdo->prepare($query);
    $authorIds = isset($_POST['author_ids']) ? $_POST['author_ids'] : [];
    foreach ($authorIds as $authorId) {
      $stmt->execute(['book_id' => $id, 'author_id' => $authorId]);
    }

    $pdo->commit();
    header("Location: ../../pages/books/index.php");
    exit;
  } catch (PDOException $e) {
    $pdo->rollBack();
    throw $e;
  }
}
?>
