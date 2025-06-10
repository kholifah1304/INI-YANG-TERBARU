<?php
session_start();
include "../../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $alamat = $_POST['alamat'];
    $info = $_POST['info'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $id_user = $_COOKIE['id_user'];

    // Upload bukti pembayaran
    $bukti_pembayaran = $_FILES['bukti']['name'];
    $bukti_pembayaran_tmp = $_FILES['bukti']['tmp_name'];
    $upload_dir = "../../assets/";

    if (!move_uploaded_file($bukti_pembayaran_tmp, $upload_dir . $bukti_pembayaran)) {
        die("Gagal upload bukti pembayaran!");
    }

    // Ambil harga produk
    $stmt_produk = $koneksi->prepare("SELECT harga FROM produk WHERE id_produk = ?");
    $stmt_produk->bind_param("i", $product_id);
    $stmt_produk->execute();
    $result_produk = $stmt_produk->get_result();
    $produk = $result_produk->fetch_assoc();
    $total_bayar = $produk['harga'] * $quantity;

    // 1. Simpan ke keranjang
    $stmt_keranjang = $koneksi->prepare("INSERT INTO keranjang (id_produk, id_user, quantity, total) VALUES (?, ?, ?, ?)");
    $stmt_keranjang->bind_param("iiii", $product_id, $id_user, $quantity, $total_bayar);
    $stmt_keranjang->execute();
    $id_keranjang = $koneksi->insert_id;

   // 1. Simpan pesanan lebih dulu tanpa pengiriman
$status = "Menunggu Pembayaran";
$stmt_pesanan = $koneksi->prepare("INSERT INTO pesanan (id_keranjang, id_pengiriman, status, bukti_pembayaran) VALUES (?, NULL, ?, ?)");
$stmt_pesanan->bind_param("iss", $id_keranjang, $status, $bukti_pembayaran);
$stmt_pesanan = $koneksi->prepare("INSERT INTO pesanan (id_keranjang, id_pengiriman, status, bukti_pembayaran) VALUES (?, NULL, ?, ?)");
if (!$stmt_pesanan) {
    die("Prepare pesanan gagal: " . $koneksi->error);
}
$stmt_pesanan->bind_param("iss", $id_keranjang, $status, $bukti_pembayaran);
if (!$stmt_pesanan->execute()) {
    die("Execute pesanan gagal: " . $stmt_pesanan->error);
}
$id_pesanan = $koneksi->insert_id;

// 2. Simpan pengiriman (pakai id_pesanan baru)
$metode_pengiriman = $_POST['metode_pengiriman']; // pastikan ini ada di form
$stmt_pengiriman = $koneksi->prepare("INSERT INTO pengiriman (id_pesanan, alamat_tujuan, metode_pengiriman, status_pengiriman) VALUES (?, ?, ?, ?)");
$status_pengiriman = "Belum Dikirim";
$stmt_pengiriman->bind_param("isss", $id_pesanan, $alamat, $metode_pengiriman, $status_pengiriman);
if (!$stmt_pengiriman->execute()) {
    die("Gagal simpan pengiriman: " . $stmt_pengiriman->error);
}
$id_pengiriman = $koneksi->insert_id;

// 3. Update pesanan agar id_pengiriman terisi
$stmt_update_pesanan = $koneksi->prepare("UPDATE pesanan SET id_pengiriman = ? WHERE id_pesanan = ?");
$stmt_update_pesanan->bind_param("ii", $id_pengiriman, $id_pesanan);
$stmt_update_pesanan->execute();

// 4. Simpan pembayaran
$id_metodePembayaran = 1;
$stmt_pembayaran = $koneksi->prepare("INSERT INTO pembayaran (id_pesanan, id_metodePembayaran, total_bayar) VALUES (?, ?, ?)");
$stmt_pembayaran->bind_param("iii", $id_pesanan, $id_metodePembayaran, $total_bayar);
$stmt_pembayaran->execute();

    header("Location: order.php");
    exit;
}
?>
