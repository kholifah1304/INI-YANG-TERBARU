<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM produk WHERE id=$id";
$result = $conn->query($query);
if ($result->num_rows == 0) {
    echo "Produk tidak ditemukan.";
    exit;
}

$produk = $result->fetch_assoc();

// Proses Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = $_POST['kategori'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $update = "UPDATE produk SET kategori='$kategori', nama='$nama', stok=$stok, harga=$harga WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Gagal update: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form method="POST">
            <h2>Edit Produk</h2>

            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" value="<?= htmlspecialchars($produk['kategori']) ?>" required>

            <label for="nama">Product Name</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($produk['nama']) ?>" required>

            <div class="row">
                <div>
                    <label for="stok">Stock</label>
                    <input type="number" name="stok" id="stok" value="<?= $produk['stok'] ?>" required>
                </div>

                <div>
                    <label for="harga">Price</label>
                    <input type="number" name="harga" id="harga" value="<?= $produk['harga'] ?>" required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="update-button">Update</button>
                <a href="index.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
