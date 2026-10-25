<?php
require_once __DIR__ . "/../../repositories/category-repository.php";
require_once __DIR__ . "/../../repositories/author-repository.php";

session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

$categories = getCategories();
$authors = getAuthors();

$pageTitle = "Tambah Buku";
$pageSubtitle = "Lengkapi data buku, kategori, dan penulis";
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Buku - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/books/create.css">
</head>

<body>
  <div class="app-shell">
    <?php require_once __DIR__ . "/../../components/admin/sidebar.php" ?>

    <main class="app-main">
      <?php require_once __DIR__ . "/../../components/admin/topbar.php" ?>

      <div class="app-content">
        <form method="POST" action="../../actions/books/store.php">
          <div class="form-card" style="margin-bottom:20px;">
            <div class="form-section-title">Data Buku</div>
            <div class="form-group">
              <label for="title">Judul Buku</label>
              <input type="text" id="title" name="title" placeholder="Contoh: Laskar Pelangi" value="<?= $old['title'] ?? '' ?>">
              <?= isset($errors['title']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['title'] . "</div>" : '' ?>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-979-1227-78-0" value="<?= $old['isbn'] ?? '' ?>">
                <?= isset($errors['isbn']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['isbn'] . "</div>" : '' ?>
              </div>
              <div class="form-group">
                <label for="year">Tahun Terbit</label>
                <input type="number" id="year" name="year" placeholder="Contoh: 2005" value="<?= $old['year'] ?? '' ?>">
                <?= isset($errors['year']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['year'] . "</div>" : '' ?>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="stock">Jumlah Stok</label>
                <input type="number" id="stock" name="stock" placeholder="Contoh: 10" value="<?= $old['stock'] ?? '' ?>">
                <?= isset($errors['stock']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['stock'] . "</div>" : '' ?>
              </div>
              <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id">
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($old['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <?= isset($errors['category_id']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['category_id'] . "</div>" : '' ?>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea id="description" name="description" rows="3" placeholder="Sinopsis singkat buku"><?= $old['description'] ?? '' ?></textarea>
              <?= isset($errors['description']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['description'] . "</div>" : '' ?>
            </div>
          </div>

          <div class="form-card">
            <div class="form-section-title">Penulis Buku</div>
            <div class="form-group">
              <label>Pilih Penulis (bisa lebih dari satu)</label>
              <div class="checkbox-grid">
                <?php foreach ($authors as $author): ?>
                  <label class="checkbox-item">
                    <input type="checkbox" name="author_ids[]" value="<?= $author['id'] ?>" <?= in_array($author['id'], $old['author_ids'] ?? []) ? 'checked' : '' ?>>
                    <?= $author['name'] ?>
                  </label>
                <?php endforeach; ?>
              </div>
              <?= isset($errors['author_ids']) ? "<div style='color:red;font-size:12px;margin-top:4px;'>" . $errors['author_ids'] . "</div>" : '' ?>
            </div>

            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="store" class="btn btn-primary">Simpan Buku</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>
