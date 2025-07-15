<?php
include '../../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: ../dataproduk/data_produk.php");
    exit();
}

$id_produk = $_GET['id'];

// Ambil data produk
$produkQuery = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_assoc($produkQuery);

// Ambil data kategori
$kategoriQuery = mysqli_query($koneksi, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Produk</h2>
        <form action="proses_edit.php" method="POST" enctype="multipart/form-data" autocomplete="off">
         <input type="hidden" name="id_produk" value="<?= htmlspecialchars($produk['id_produk']) ?>">

    <label for="id_kategori">Kategori</label>
    <select name="id_kategori" id="id_kategori" required>
        <?php while ($kat = mysqli_fetch_assoc($kategoriQuery)) : ?>
            <option value="<?= $kat['id_kategori'] ?>" <?= ($kat['id_kategori'] == $produk['id_kategori']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kat['nama_kategori']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="nama_produk">Nama Produk</label>
    <input type="text" name="nama_produk" id="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>

    <label for="deskripsi">Deskripsi</label>
    <input type="text" name="deskripsi" id="deskripsi" value="<?= htmlspecialchars($produk['deskripsi']) ?>" required>

    <label for="stok">Stok</label>
    <input type="number" name="stok" id="stok" value="<?= (int)$produk['stok'] ?>" required>

    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" value="<?= (int)$produk['harga'] ?>" required>

    <label for="foto_produk">Foto Produk (opsional)</label>
    <input type="file" name="foto_produk" id="foto_produk" accept="image/*">

    <?php if (!empty($produk['foto_produk'])) : ?>
        <p>Foto Saat Ini:</p>
        <img src="../../../gambar_produk/<?= htmlspecialchars($produk['foto_produk']) ?>" alt="Foto Produk" style="max-width: 150px;">
    <?php endif; ?>

    <div class="button-group">
        <button type="submit" onclick="return confirm('Yakin ingin memperbarui produk ini?')">Update</button>
        <a href="../dataproduk/data_produk.php" class="cancel-btn">Batal</a>
    </div>
</form>
</body>
</html>