<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
  try {
    $pdo->beginTransaction();

    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id'];

    $query = "insert into books (title, isbn, year, stock, description, category_id) values (:title, :isbn, :year, :stock, :description, :category_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':title' => $title,
      ':isbn' => $isbn,
      ':year' => $year,
      ':stock' => $stock,
      ':description' => $description,
      ':category_id' => $categoryId
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
