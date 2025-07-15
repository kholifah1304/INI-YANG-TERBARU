<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $folder = "uploads/";

    // Buat folder jika belum ada
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // Simpan gambar
    if (move_uploaded_file($tmp_name, $folder . $gambar)) {
        echo "<h2>Produk berhasil ditambahkan!</h2>";
        echo "<p>Nama Produk: $nama</p>";
        echo "<p>Deskripsi: $deskripsi</p>";
        echo "<p>Stok: $stok</p>";
        echo "<p>Harga: Rp. $harga</p>";
        echo "<p>Kategori: $kategori</p>";
        echo "<img src='" . $folder . $gambar . "' width='200'><br><br>";
        echo "<a href='form.html'>Tambah Produk Lagi</a>";
    } else {
        echo "Gagal upload gambar.";
    }
}
?>