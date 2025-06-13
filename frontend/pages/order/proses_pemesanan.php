<?php
session_start();
include "../../../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];
    $alamat = $_POST['alamat'];
    $info = $_POST['info'];
    $metode_pengiriman = $_POST['metode_pengiriman'];
    $id_user = $_COOKIE['id_user'] ?? null;
    $total_bayar = (int) $_POST['total']; // Total dari form, sudah termasuk ongkir

    if (!$id_user) {
        echo "User belum login!";
        exit;
    }

    // Upload bukti pembayaran
    $bukti_pembayaran = $_FILES['bukti']['name'];
    $bukti_pembayaran_tmp = $_FILES['bukti']['tmp_name'];
    $upload_dir = "../../assets/";

    if (!move_uploaded_file($bukti_pembayaran_tmp, $upload_dir . $bukti_pembayaran)) {
        die("Gagal upload bukti pembayaran!");
    }

    // 1. Simpan ke keranjang
    $stmt_keranjang = $koneksi->prepare("INSERT INTO keranjang (id_produk, id_user, quantity, total) VALUES (?, ?, ?, ?)");
    if (!$stmt_keranjang) {
        die("Prepare keranjang gagal: " . $koneksi->error);
    }
    $stmt_keranjang->bind_param("iiii", $product_id, $id_user, $quantity, $total_bayar);
    $stmt_keranjang->execute();
    $id_keranjang = $koneksi->insert_id;

    // 2. Simpan pesanan (sementara tanpa id_pengiriman)
    $status_pesanan = "Menunggu Pembayaran";
    $stmt_pesanan = $koneksi->prepare("INSERT INTO pesanan (id_keranjang, id_pengiriman, status, bukti_pembayaran) VALUES (?, NULL, ?, ?)");
    if (!$stmt_pesanan) {
        die("Prepare pesanan gagal: " . $koneksi->error);
    }
    $stmt_pesanan->bind_param("iss", $id_keranjang, $status_pesanan, $bukti_pembayaran);
    if (!$stmt_pesanan->execute()) {
        die("Execute pesanan gagal: " . $stmt_pesanan->error);
    }
    $id_pesanan = $koneksi->insert_id;

    // 3. Simpan pengiriman
    $status_pengiriman = "Belum Dikirim";
    $stmt_pengiriman = $koneksi->prepare("INSERT INTO pengiriman (id_pesanan, alamat_tujuan, metode_pengiriman, status_pengiriman) VALUES (?, ?, ?, ?)");
    if (!$stmt_pengiriman) {
        die("Prepare pengiriman gagal: " . $koneksi->error);
    }
    $stmt_pengiriman->bind_param("isss", $id_pesanan, $alamat, $metode_pengiriman, $status_pengiriman);
    if (!$stmt_pengiriman->execute()) {
        die("Gagal simpan pengiriman: " . $stmt_pengiriman->error);
    }
    $id_pengiriman = $koneksi->insert_id;

    // 4. Update pesanan agar id_pengiriman terisi
    $stmt_update = $koneksi->prepare("UPDATE pesanan SET id_pengiriman = ? WHERE id_pesanan = ?");
    if (!$stmt_update) {
        die("Prepare update pesanan gagal: " . $koneksi->error);
    }
    $stmt_update->bind_param("ii", $id_pengiriman, $id_pesanan);
    $stmt_update->execute();

    // 5. Simpan pembayaran (sementara id_metodePembayaran = 1 sebagai default)
    $id_metodePembayaran = 1;
    $stmt_pembayaran = $koneksi->prepare("INSERT INTO pembayaran (id_pesanan, id_metodePembayaran, total_bayar) VALUES (?, ?, ?)");
    if (!$stmt_pembayaran) {
        die("Prepare pembayaran gagal: " . $koneksi->error);
    }
    $stmt_pembayaran->bind_param("iii", $id_pesanan, $id_metodePembayaran, $total_bayar);
    $stmt_pembayaran->execute();

    // 6. Redirect
    header("Location: order.php");
    exit;
}
?>
