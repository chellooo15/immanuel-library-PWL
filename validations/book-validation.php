<?php
require_once __DIR__ . "/../repositories/book-repository.php";
require_once __DIR__ . "/../repositories/category-repository.php";
require_once __DIR__ . "/../repositories/author-repository.php";

function getBookRequest($request)
{
  return [
    'title' => trim(htmlspecialchars($request['title'] ?? '')),
    'isbn' => trim(htmlspecialchars($request['isbn'] ?? '')),
    'year' => trim(htmlspecialchars($request['year'] ?? '')),
    'stock' => trim(htmlspecialchars($request['stock'] ?? '')),
    'category_id' => trim(htmlspecialchars($request['category_id'] ?? '')),
    'description' => trim(htmlspecialchars($request['description'] ?? '')),
    'author_ids' => isset($request['author_ids']) && is_array($request['author_ids']) ? $request['author_ids'] : [],
  ];
}

function validateBook($request, $ignoreBookId = 0)
{
  global $pdo;
  $errors = [];
  $data = getBookRequest($request);

  if (empty($data['title'])) {
    $errors['title'] = "Judul buku wajib diisi";
  } elseif (strlen($data['title']) > 100) {
    $errors['title'] = "Judul buku tidak boleh melebihi dari 100 karakter";
  }

  if (empty($data['isbn'])) {
    $errors['isbn'] = "ISBN wajib diisi";
  } elseif (isIsbnTaken($data['isbn'], $ignoreBookId)) {
    $errors['isbn'] = "ISBN sudah terdaftar sebelumnya";
  }

  if (empty($data['year'])) {
    $errors['year'] = "Tahun terbit wajib diisi";
  } elseif (!is_numeric($data['year'])) {
    $errors['year'] = "Tahun terbit wajib diisi dengan angka";
  }

  if (empty($data['stock'])) {
    $errors['stock'] = "Stok wajib diisi";
  } elseif (!is_numeric($data['stock'])) {
    $errors['stock'] = "Stok wajib diisi dengan angka";
  }

  if (empty($data['category_id'])) {
    $errors['category_id'] = "Kategory wajib dipilih";
  } elseif (!isCategoryExists($data['category_id'])) {
    $errors['category_id'] = "Kategory yang dipilih tidak valid";
  }

  if (empty($data['description'])) {
    $errors['description'] = "Deskripsi buku wajib disisi";
  } elseif (strlen($data['description']) > 100) {
    $errors['description'] = "Deskripsi buku tidak boleh melebihi dari 100 karakter";
  }

  if (empty($data['author_ids'])) {
    $errors['author_ids'] = "Penulis buku wajib dipilih";
  } else {
    $placeholders = implode(',', array_fill(0, count($data['author_ids']), '?'));
    $query = "select count(*) from authors where id in ($placeholders)";
    $stmt = $pdo->prepare($query);
    $stmt->execute($data['author_ids']);
    if ($stmt->fetchColumn() !== count($data['author_ids'])) {
      $errors['author_ids'] = "Ada Penulis buku yang dipilih tidak valid";
    }
  }

  return $errors;
}
