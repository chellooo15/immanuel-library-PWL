<?php
$host = "103.119.237.131";
$dbname = "cpdicx55109_immanuel_library";
$username = "cpdicx55109_immanuel_library";
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
