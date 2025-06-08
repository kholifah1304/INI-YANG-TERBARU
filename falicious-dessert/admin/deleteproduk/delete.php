<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Proses hapus data dari database seharusnya di sini
  // Contoh: DELETE FROM produk WHERE id = $id;

  // Setelah hapus, redirect kembali ke index
  header("Location: index.php");
  exit();
}
?>
