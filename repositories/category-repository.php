<?php
require_once __DIR__ . "/../config/database.php";

function getCategories()
{
  global $pdo;
  $query = "select c.id, c.name, c.description, count(b.id) as total_books from categories c left join books b on b.category_id = c.id group by c.id order by c.id";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getCategory()
{
  $category = [
    "id"          => 1,
    "name"        => "Fiksi",
    "description" => "Novel dan cerita rekaan",
  ];

  return $category;
}

function isCategoryExists($categoryId)
{
  global $pdo;
  $query = "select count(*) from categories where id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['id' => $categoryId]);
  return $stmt->fetchColumn() > 0;
}
