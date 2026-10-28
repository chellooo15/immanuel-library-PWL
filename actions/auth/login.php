<?php
session_start();

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/auth-validation.php";
require_once __DIR__ . "/../../repositories/user-repository.php";

if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $request = getLoginRequest($_POST);
    $errors = validateLogin($request);

    if (count($errors) > 0) {
      $_SESSION['old'] = $request;
      $_SESSION['errors'] = $errors;
      header('Location: ../../pages/auth/login.php');
      exit;
    }

    $user = getUserByEmail($request['email']);
    if (!$user || !password_verify($request['password'], $user['password'])) {
      $_SESSION['errors']['email'] = "Email atau kata sandi salah";
      $_SESSION['old'] = $request;
      header('Location: ../../pages/auth/login.php');
      exit;
    }

    $_SESSION['user'] = $user;
    header('Location: ../../pages/books/index.php');
    exit;
  } catch (PDOException $e) {
    throw $e;
  }
}
