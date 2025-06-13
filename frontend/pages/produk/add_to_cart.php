<?php
session_start();
include "../../../koneksi.php";

// Check login
if (!isset($_COOKIE['id_user'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu";
    header('Location: http://localhost/app_dessert/frontend/pages/auth/login.php');
    exit();
}

$id_user   = (int)$_COOKIE['id_user'];
$id_produk = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity  = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Validate input
if ($id_produk <= 0 || $quantity <= 0) {
    $_SESSION['error'] = "Data produk tidak valid";
    header('Location: http://localhost/app_dessert/frontend/pages/produk/produk.php');
    exit();
}

try {
    // Get product data
    $stmt = $koneksi->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Produk tidak ditemukan";
        header('Location: http://localhost/app_dessert/frontend/pages/produk/produk.php');
        exit();
    }

    $produk = $result->fetch_assoc();
    $harga  = $produk['harga'];
    $stok   = $produk['stok'];

    if ($quantity > $stok) {
        $_SESSION['error'] = "Stok tidak mencukupi. Stok tersedia: " . $stok;
        header('Location: http://localhost/app_dessert/frontend/pages/produk/produk.php');
        exit();
    }

    $total = $harga * $quantity;

    // Check if product already in cart
    $stmt = $koneksi->prepare("SELECT id_keranjang, quantity FROM keranjang WHERE id_user = ? AND id_produk = ? AND id_pesanan IS NULL");
    $stmt->bind_param("ii", $id_user, $id_produk);
    $stmt->execute();
    $cek_result = $stmt->get_result();

    if ($cek_result->num_rows > 0) {
        $item = $cek_result->fetch_assoc();
        $new_qty = $item['quantity'] + $quantity;

        if ($new_qty > $stok) {
            $_SESSION['error'] = "Jumlah melebihi stok tersedia. Stok tersedia: " . $stok;
            header('Location: http://localhost/app_dessert/frontend/pages/produk/produk.php');
            exit();
        }

        $new_total = $new_qty * $harga;
        $stmt = $koneksi->prepare("UPDATE keranjang SET quantity = ?, total = ? WHERE id_keranjang = ?");
        $stmt->bind_param("idi", $new_qty, $new_total, $item['id_keranjang']);
    } else {
        $stmt = $koneksi->prepare("INSERT INTO keranjang (id_user, id_produk, quantity, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_user, $id_produk, $quantity, $total);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang";
    } else {
        $_SESSION['error'] = "Gagal menambahkan produk ke keranjang";
    }

    header('Location: http://localhost/app_dessert/frontend/pages/order/keranjang.php');
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    header('Location: http://localhost/app_dessert/frontend/pages/produk/produk.php');
    exit();
}
