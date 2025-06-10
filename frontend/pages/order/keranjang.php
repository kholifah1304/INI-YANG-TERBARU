<?php
session_start();
include "../../koneksi.php"; // sesuaikan path-nya

$id_user = $_COOKIE['id_user']; // ambil dari cookie login

// Ambil isi keranjang user
$sql = "SELECT k.quantity, k.total, p.nama_produk, p.harga, p.foto_produk 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk 
        WHERE k.id_user = ?";
$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    die("Query error: " . $koneksi->error);
}

$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$keranjang = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KERANJANG</title>
    <link rel="stylesheet" href="http://localhost/app_dessert/frontend/assets/style.css"> <!-- PERBAIKAN PATH -->
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
                <a href="http://localhost/app_dessert/frontend/pages/order/keranjang.php"><span class="icon-cart">🛒</span></a>
                <a href="http://localhost/app_dessert/frontend/pages/auth/login.php"><span class="icon-user">👤</span></a>
            </div>
        </div>
    </header>

    <section class="order-section">
        <div class="order-overlay">
            <h2>Keranjang</h2>
            <p>Tambahkan varian favoritmu ke keranjang dan pesan sekarang juga! <br> Jangan sampai kehabisan!</p>
        </div>
    </section>

    <section class="order-list">
        <h2>Keranjang</h2>

        <div class="cart">
            <div class="cart-header">
                <div>Product</div>
                <div>Price</div>
                <div>Quantity</div>
                <div>Total</div>
            </div>

            <<?php $grand_total = 0; ?>
                <?php foreach ($keranjang as $item): ?>
                <div class="cart-item">
                <div class="product-info">
                    <span class="delete-btn">🗑️</span>
                    <img src="http://localhost/app_dessert/frontend/assets/<?= $item['foto_produk'] ?>" alt="<?= $item['nama_produk'] ?>" />
                    <span><?= $item['nama_produk'] ?></span>
                </div>
                <div class="unit-price" data-price="<?= $item['harga'] ?>">Rp<?= number_format($item['harga'], 0, ',', '.') ?></div>
                <div><input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" disabled></div>
                <div class="item-total">Rp<?= number_format($item['total'], 0, ',', '.') ?></div>
        </div>
        <?php $grand_total += $item['total']; ?>
    <?php endforeach; ?>

    <div class="cart-total">
        <span>Cart Total</span>
        <span id="cart-total">Rp<?= number_format($grand_total, 0, ',', '.') ?></span>
    </div>

    <script>
        const quantityInput = document.querySelector('.quantity-input');
        const unitPrice = parseInt(document.querySelector('.unit-price').dataset.price);
        const itemTotal = document.querySelector('.item-total');
        const cartTotal = document.getElementById('cart-total');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);
        }

        quantityInput.addEventListener('input', () => {
            const qty = parseInt(quantityInput.value) || 1;
            const total = unitPrice * qty;
            itemTotal.textContent = formatRupiah(total);
            cartTotal.textContent = formatRupiah(total);
        });
    </script>
    <!-- <div class="line">
            <p>Keranjang anda kosong.</p>
            <hr>
        </div><br>
        <a href="http://localhost/app_dessert/frontend/pages/produk/produk.php" class="show-product-btn">Show Product</a>-->
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Ikuti Kami</h3>
                <div class="socmed-section">
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