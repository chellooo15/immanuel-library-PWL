<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/book-validation.php";

session_start();

if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
  $errors = validateBook($_POST);

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = getBookRequest($_POST);
    header("Location: ../../pages/books/create.php");
    exit;
  }

  try {
    $pdo->beginTransaction();

    $data = getBookRequest($_POST);

    $query = "insert into books (title, isbn, year, stock, description, category_id) values (:title, :isbn, :year, :stock, :description, :category_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':title' => $data['title'],
      ':isbn' => $data['isbn'],
      ':year' => $data['year'],
      ':stock' => $data['stock'],
      ':description' => $data['description'],
      ':category_id' => $data['category_id']
    ]);

    $bookId = $pdo->lastInsertId();

    if (isset($_POST['author_ids']) && is_array($_POST['author_ids'])) {
      $query = "insert into book_author (book_id, author_id) values (:book_id, :author_id)";
      $stmt = $pdo->prepare($query);
      foreach ($_POST['author_ids'] as $authorId) {
        $stmt->execute([
          ':book_id' => $bookId,
          ':author_id' => $authorId
        ]);
      }
    }

    $pdo->commit();
    header("Location: ../../pages/books/index.php");
    exit;
  } catch (PDOException $e) {
    $pdo->rollBack();
    die("Gagal menyimpan buku: " . $e->getMessage());
  }
}
?>
