<?php
include "../../../koneksi.php"; // Pastikan koneksi database disertakan

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Hindari SQL Injection

    // Hapus data dari tabel produk
    $query = "DELETE FROM produk WHERE id_produk = ?";
    $stmt = $koneksi->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Redirect kembali ke halaman data produk setelah berhasil hapus
            header("Location: ../dataproduk/data_produk.php");
            exit();
        } else {
            echo "Gagal menghapus produk: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Query gagal: " . $koneksi->error;
    }
} else {
    echo "ID produk tidak ditemukan!";
}
?>
