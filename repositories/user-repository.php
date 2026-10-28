<?php

function getUsers()
{
  global $pdo;

  $query = "SELECT * FROM users";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  return $stmt->fetchAll();
}

function getUserByEmail($email)
{
  global $pdo;

  $query = "SELECT * FROM users WHERE email = :email";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'email' => $email,
  ]);

  return $stmt->fetch();
}

function isEmailTaken($email)
{
  global $pdo;

  $query = "SELECT COUNT(id) FROM users WHERE email = :email";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'email' => $email,
  ]);

  return $stmt->fetchColumn() > 0;
}

function getUser()
{
  $user = [
    "id"    => 2,
    "name"  => "Budi Santoso",
    "email" => "budi.santoso@siswa.ski.sch.id",
    "role"  => "member",
  ];

  return $user;
}

function getProfile()
{
  $profile = [
    "user_id" => 2,
    "phone"   => "0812-3456-7890",
    "address" => "Jl. Merdeka No. 21, Pontianak, Kalimantan Barat",
    "bio"     => "Murid kelas XI TKJ yang gemar membaca novel fiksi dan buku pengembangan diri.",
  ];

  return $profile;
}
