<?php
$host = "194.233.65.45";
$dbname = "cpfpqh1642_immanuel_library";
$username = "cpfpqh1642_immanuel_library";
$password = "chello@1290";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];
try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $error) {
  die("Koneksi ke database gagal: " . $error->getMessage());
}
?>
