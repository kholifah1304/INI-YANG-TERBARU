<?php
session_start();
include "../../../koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek login
if (!isset($_COOKIE['id_user'])) {
    header('Location: /login.php');
    exit();
}

$id_user   = (int) $_COOKIE['id_user'];
$id_produk = $_POST['product_id'] ?? null;
$quantity  = (int) ($_POST['quantity'] ?? 1);

// Validasi input
if (!$id_produk || $quantity <= 0) {
    $_SESSION['error'] = "Data produk tidak valid.";
    header('Location: /produk.php');
    exit();
}

try {
    // Ambil data produk
    $stmt = $koneksi->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Produk tidak ditemukan.";
        header('Location: /produk.php');
        exit();
    }

    $produk = $result->fetch_assoc();
    $harga  = $produk['harga'];
    $stok   = $produk['stok'];

    if ($quantity > $stok) {
        $_SESSION['error'] = "Stok tidak mencukupi.";
        header('Location: /produk.php');
        exit();
    }

    $total = $harga * $quantity;

    // Cek apakah produk sudah ada di keranjang
    $stmt = $koneksi->prepare("SELECT id_keranjang, quantity FROM keranjang WHERE id_user = ? AND id_produk = ? AND id_pesanan IS NULL");
    $stmt->bind_param("ii", $id_user, $id_produk);
    $stmt->execute();
    $cek_result = $stmt->get_result();

    if ($cek_result->num_rows > 0) {
        $item    = $cek_result->fetch_assoc();
        $new_qty = $item['quantity'] + $quantity;

        if ($new_qty > $stok) {
            $_SESSION['error'] = "Jumlah melebihi stok tersedia.";
            header('Location: /produk.php');
            exit();
        }

        $new_total = $new_qty * $harga;
        $stmt = $koneksi->prepare("UPDATE keranjang SET quantity = ?, total = ? WHERE id_keranjang = ?");
        $stmt->bind_param("idi", $new_qty, $new_total, $item['id_keranjang']);
        $stmt->execute();
    } else {
        $stmt = $koneksi->prepare("INSERT INTO keranjang (id_user, id_produk, quantity, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_user, $id_produk, $quantity, $total);
        $stmt->execute();
    }

    $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang.";
    header('Location: /keranjang.php');
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    header('Location: /produk.php');
    exit();
}
