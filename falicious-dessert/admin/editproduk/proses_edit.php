<?php
include "../../../koneksi.php";

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if (
    isset($_POST['id_produk'], $_POST['id_kategori'], $_POST['nama_produk'], $_POST['stok'], $_POST['harga'], $_POST['deskripsi'])
) {
    $id_produk   = intval($_POST['id_produk']);
    $id_kategori = intval($_POST['id_kategori']);
    $nama_produk = trim($_POST['nama_produk']);
    $stok        = intval($_POST['stok']);
    $harga       = intval($_POST['harga']);
    $deskripsi   = trim($_POST['deskripsi']);
    $foto_name   = null;

    if ($id_produk <= 0 || $id_kategori <= 0 || $stok < 0 || $harga < 0 || empty($nama_produk)) {
        echo "<script>alert('Data tidak valid.'); window.history.back();</script>";
        exit;
    }

    // Upload foto jika ada file baru
    if (isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] === 0) {
        $foto_tmp = $_FILES['foto_produk']['tmp_name'];
        $foto_ext = strtolower(pathinfo($_FILES['foto_produk']['name'], PATHINFO_EXTENSION));
        $foto_name = uniqid('produk_') . '.' . $foto_ext;
        $target_dir = "../../../gambar_produk/";
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($foto_ext, $allowed_ext)) {
            echo "<script>alert('Format gambar tidak valid.'); window.history.back();</script>";
            exit;
        }

        if (!move_uploaded_file($foto_tmp, $target_dir . $foto_name)) {
            echo "<script>alert('Gagal upload gambar.'); window.history.back();</script>";
            exit;
        }
    }

    // SQL dengan atau tanpa gambar
    if ($foto_name) {
        $sql = "UPDATE produk 
                SET id_kategori=?, nama_produk=?, stok=?, harga=?, deskripsi=?, foto_produk=?
                WHERE id_produk=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("isiissi", $id_kategori, $nama_produk, $stok, $harga, $deskripsi, $foto_name, $id_produk);
    } else {
        $sql = "UPDATE produk 
                SET id_kategori=?, nama_produk=?, stok=?, harga=?, deskripsi=?
                WHERE id_produk=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("isiisi", $id_kategori, $nama_produk, $stok, $harga, $deskripsi, $id_produk);
    }

    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil diperbarui!'); window.location='../dataproduk/data_produk.php';</script>";
        } else {
            echo "<script>alert('Gagal update: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Gagal menyiapkan perintah SQL.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
}

$koneksi->close();
