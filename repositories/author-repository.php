<?php
require_once __DIR__ . "/../config/database.php";

function getAuthors()
{
  global $pdo;
  $query = "select a.id, a.name, count(ba.book_id) as total_books from authors a left join book_author ba on ba.author_id = a.id group by a.id order by a.id";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll();
}

function getAuthor()
{
  $author = [
    "id"   => 1,
    "name" => "Andrea Hirata",
    "bio"  => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.",
  ];

  return $author;
}
