<?php
session_start();

require_once __DIR__ . "/../../middleware/auth.php";

requireGuest();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/auth/login.css">
</head>

<body>

  <div class="auth-wrapper">
    <div class="auth-card">
      <div class="auth-logo">
        <span class="logo-badge">PD</span>
        Perpustakaan Digital
      </div>
      <h1>Selamat Datang Kembali</h1>
      <p class="auth-subtitle">Masuk untuk mengelola koleksi buku perpustakaan.</p>

      <?php if (isset($errors) && !is_array($errors)): ?>
        <div style="background: #fee2e2; color: #991b2c; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 14px;">
          <?= $errors ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="../../actions/auth/login.php">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= $old['email'] ?? '' ?>" placeholder="nama@sekolah.sch.id">
          <?php if (isset($errors['email'])): ?>
            <p style="font-size:12px; margin-top: 4px; color: red;"><?= $errors['email'] ?></p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" placeholder="Masukkan kata sandi">
          <?php if (isset($errors['password'])): ?>
            <p style="font-size:12px; margin-top: 4px; color: red;"><?= $errors['password'] ?></p>
          <?php endif; ?>
        </div>

        <!-- <button type="submit" name="register" class="btn btn-primary btn-block">Daftar</button> -->
        <button type="submit" name="login" class="btn btn-primary btn-block">Masuk</button>
      </form>

      <p class="form-footer-link">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
      </p>
    </div>
  </div>

</body>

</html>
