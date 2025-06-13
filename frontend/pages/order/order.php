<?php
session_start();
include "../../../koneksi.php";  // path sesuai letak file
$id_user = $_COOKIE['id_user'] ?? null;

if (!$id_user) {
    echo "User belum login";
    exit;
}

// Ambil data pesanan user
$sql = "SELECT p.id_pesanan, p.tanggal_pesanan, peng.alamat_tujuan, pm.nama_metode, pr.nama_produk, k.quantity, p.status, p.bukti_pembayaran, 
        k.total AS total_keranjang
        FROM pesanan p
        JOIN keranjang k ON p.id_keranjang = k.id_keranjang
        JOIN produk pr ON k.id_produk = pr.id_produk
        JOIN pengiriman peng ON p.id_pengiriman = peng.id_pengiriman
        JOIN pembayaran pb ON pb.id_pesanan = p.id_pesanan
        JOIN metodepembayaran pm ON pm.id_metodePembayaran = pb.id_metodePembayaran
        WHERE k.id_user = ?";

$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    die("Prepare failed: (" . $koneksi->errno . ") " . $koneksi->error);
}
$stmt->bind_param("i", $id_user);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order | SLDessert</title>
    <link rel="stylesheet" href="http://localhost/app_dessert/frontend/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
</head>
<body>
    
    <header>
        <div class="header-left">
            <img src="http://localhost/app_dessert/frontend/assets/logo.png" alt="" class="logo">
        </div>

        <div class="header-center">
        <nav>
            <ul>
                <li><a href="http://localhost/app_dessert/frontend/pages/home.php">Home</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/produk/produk.php">Product</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/about.php">About Us</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/order/order.php">Order</a></li>
            </ul>
        </nav>
        </div>

        <div class="header-right">
            <div class="search-container">
                <i class="fa fa-search search-icon" a href="http://localhost/app_dessert/frontend/pages/produk/produk.php"></a></i>
                <input type="text" placeholder="search product...">
            </div>
            <div class="icons">
                <a href="http://localhost/app_dessert/frontend/pages/auth/login.php"><span class="icon-user">👤</span></a>
            </div>
        </div>
    </header>

    <section class="order-section">
        <div class="order-overlay">
            <h2>Order/Pesanan</h2>
            <p>Pilih varian favoritmu dan pesan sekarang juga! <br> Jangan sampai kehabisan!</p>
        </div>
    </section>

    <section class="order-list">
        <h2>Daftar Pesanan</h2>

        <div style="display: grid; grid-template-columns: auto auto auto; gap: 5px;">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card-order-detail">
                    <p><strong>Tanggal Pesanan:</strong> <?= date('d/m/Y', strtotime($row['tanggal_pesanan'])) ?></p>
                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat_tujuan']) ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($row['nama_metode']) ?></p>
                    <p><strong>Nama Pesanan:</strong> <?= htmlspecialchars($row['nama_produk']) ?> (<?= $row['quantity'] ?>)</p>
                    
                    <?php
                        $ongkir = 8000;
                        $total_final = $row['total_keranjang']; // Jika total di DB sudah termasuk ongkir, hapus $ongkir
                    ?>
                    <p><strong style="color: red;">Total:</strong> Rp<?= number_format($total_final, 0, ',', '.') ?></p>
                    <p><strong>Status Pesanan:</strong> <?= htmlspecialchars($row['status']) ?></p>
                    <a href="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" class="bukti-transfer-link">Lihat bukti transfer</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p><center>Anda belum memiliki pesanan.</center></p><br>
            <a href="http://localhost/app_dessert/frontend/pages/produk/produk.php" 
            class="show-product-btn" 
            style="display: inline-block; margin-top: 10px; padding: 10px 20px; width: auto; text-align: center;">
            Show Product
        </a>
<?php endif; ?>

        </div>
    </section>


    <footer>
        <div class="footer-container">
        <div class="footer-section">
            <h3>Ikuti Kami</h3>
            <div class="socmed-section" >
                <a href="https://www.instagram.com/shnatio__?utm_source=ig_web_button_share_sheet&igsh=MTRucXRwcGlpbmVrZA==" target="_blank"><i class="fa fa-instagram social-icons"></i></a>  
            </div>
        </div>
        <div class="footer-section">
            <h3>Links</h3>
            <ul>
                <li><a href="http://localhost/app_dessert/frontend/pages/home.php">Home</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/produk/produk.php">Product</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/about.php">About Us</a></li>
                <li><a href="http://localhost/app_dessert/frontend/pages/order/order.php">Order</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>+62 822-6504-9551</p>
            <p>+62 812-6890-4012</p>
        </div>
        <div class="footer-section">
            <h4>Locations</h4>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.554256046068!2d109.34410847357361!3d-7.403735972900789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6559b9ff8d3795%3A0xa58daaef273f4e44!2sSMK%20Negeri%201%20Purbalingga!5e0!3m2!1sid!2sid!4v1716216993817!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>
        <p class="footer-note">created by <span> SLDessert </span> | all rights reserved</p>
    </footer>
    
</body>
</html>