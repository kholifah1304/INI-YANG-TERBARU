<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_dessert";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM produk WHERE id = $id");

if ($result->num_rows == 0) {
    echo "Produk tidak ditemukan!";
    exit;
}

$produk = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Produk</h2>
        <form action="proses_edit.php" method="POST">
            <!-- Hidden input ID -->
            <input type="hidden" name="id" value="<?= $produk['id']; ?>">

            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" value="<?= $produk['kategori']; ?>" required>

            <label for="nama">Nama Produk</label>
            <input type="text" id="nama" name="nama" value="<?= $produk['nama']; ?>" required>

            <div class="row">
                <div class="col">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok" value="<?= $produk['stok']; ?>" required>
                </div>
                <div class="col">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" value="<?= $produk['harga']; ?>" required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn update" onclick="return confirm('Yakin ingin mengupdate produk ini?')">Update</button>
                <a href="data_produk.php" class="btn cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>