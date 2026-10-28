<?php

const LOGIN_URL = "/pages/auth/login.php";
const BOOK_INDEX_URL = "/pages/books/index.php";
const FORBIDDEN_URL = "/pages/errors/403.php";

// Mengecek apakah sebuah session itu sudah di mulai atau belum, jika belum maka session akan dimulai
function sessionStart()
{
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

// Mengecek apakah seorang pengguna sudah login atau belum
function isLoggedIn()
{
  sessionStart();
  $isLoggedIn = isset($_SESSION['user']);
  return $isLoggedIn;
}

// Mendapatkan data pengguna yang sudah login
function getAuthUser()
{
  sessionStart();
  $user = $_SESSION['user'] ?? null;
  return $user;
}

// Mengecek apakah role pengguna itu sesuai atau tidak
function hasRole(array $roles)
{
  $user = getAuthUser();
  $isUserHasAuthorizeRole = in_array($user['role'], $roles);
  return $isUserHasAuthorizeRole;
}

// Membatasi akses hanya untuk pengguna yang sudah login
function requireAuth()
{
  if (!isLoggedIn()) {
    $_SESSION['errors'] = "Silahkan login terlebih dahulu sebelum mengakses halaman ini.";
    header('Location: ' . LOGIN_URL);
    exit;
  }
}

// Membatasi akses untuk pengguna yang belum login (untuk halaman login/register)
function requireGuest()
{
  if (isLoggedIn()) {
    header('Location: ' . BOOK_INDEX_URL);
    exit;
  }
}

// Membatasi akses hanya untuk pengguna dengan role tertentu
function requireRole(array $roles)
{
  requireAuth();

  if (!hasRole($roles)) {
    header('Location: ' . FORBIDDEN_URL);
    exit;
  }
}