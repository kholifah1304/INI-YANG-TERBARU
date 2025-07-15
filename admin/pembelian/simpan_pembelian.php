<?php
// Ambil data dari form
$tanggal      = $_POST['tanggal'];
$nama_produk  = $_POST['nama_produk'];
$jumlah       = $_POST['jumlah'];
$harga        = $_POST['harga'];
$total        = $_POST['total'];
$nama         = $_POST['nama'];
$status       = $_POST['status'];

// Koneksi ke database (contoh)
$koneksi = new mysqli("localhost", "root", "", "db_dessert");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$sql = "INSERT INTO pembelian (tanggal, nama_produk, jumlah, harga, total, nama, status)
        VALUES ('$tanggal', '$nama_produk', $jumlah, $harga, $total, '$nama', '$status')";

if ($koneksi->query($sql) === TRUE) {
    echo "Data berhasil disimpan. <a href='datapembelian.php'>Lihat Data</a>";
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();
?>
