<?php
session_start();
include "../../koneksi.php";

// Check if user is logged in
if (!isset($_COOKIE['id_user'])) {
    header('Location: http://localhost/app_dessert/frontend/pages/auth/login.php');
    exit();
}

$id_user = $_COOKIE['id_user'];

// Get cart items
$sql = "SELECT k.id_keranjang, k.quantity, k.total, p.id_produk, p.nama_produk, p.harga, p.foto_produk, p.stok 
        FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk 
        WHERE k.id_user = ? AND k.id_pesanan IS NULL";
$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    die("Query error: " . $koneksi->error);
}

$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$keranjang = $result->fetch_all(MYSQLI_ASSOC);

// Handle delete item
if (isset($_GET['delete'])) {
    $id_keranjang = (int)$_GET['delete'];
    $delete_stmt = $koneksi->prepare("DELETE FROM keranjang WHERE id_keranjang = ? AND id_user = ?");
    $delete_stmt->bind_param("ii", $id_keranjang, $id_user);
    if ($delete_stmt->execute()) {
        $_SESSION['success'] = "Item berhasil dihapus dari keranjang";
        header("Location: keranjang.php");
        exit();
    }
}
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
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($keranjang)): ?>
            <div class="empty-cart">
                <p>Keranjang anda kosong.</p>
                <hr>
                <a href="http://localhost/app_dessert/frontend/pages/produk/produk.php" class="show-product-btn">Show Product</a>
            </div>
        <?php else: ?>
            <div class="cart">
                <div class="cart-header">
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Total</div>
                    <div>Action</div>
                </div>

                <?php $grand_total = 0; ?>
                <?php foreach ($keranjang as $item): ?>
                <div class="cart-item" data-id="<?= $item['id_keranjang'] ?>">
                    <div class="product-info">
                        <img src="http://localhost/app_dessert/frontend/assets/<?= $item['foto_produk'] ?>" alt="<?= $item['nama_produk'] ?>" />
                        <span><?= $item['nama_produk'] ?></span>
                    </div>
                    <div class="unit-price" data-price="<?= $item['harga'] ?>">Rp<?= number_format($item['harga'], 0, ',', '.') ?></div>
                    <div>
                        <input type="number" 
                               class="quantity-input" 
                               value="<?= $item['quantity'] ?>" 
                               min="1" 
                               max="<?= $item['stok'] ?>"
                               data-id="<?= $item['id_keranjang'] ?>">
                    </div>
                    <div class="item-total">Rp<?= number_format($item['total'], 0, ',', '.') ?></div>
                    <div>
                        <a href="?delete=<?= $item['id_keranjang'] ?>" class="delete-btn" onclick="return confirm('Hapus item dari keranjang?')">🗑️</a>
                    </div>
                </div>
                <?php $grand_total += $item['total']; ?>
                <?php endforeach; ?>

                <div class="cart-total">
                    <span>Total Belanja</span>
                    <span id="cart-total">Rp<?= number_format($grand_total, 0, ',', '.') ?></span>
                </div>

                <div class="cart-actions">
                    <a href="http://localhost/app_dessert/frontend/pages/produk/produk.php" class="continue-shopping">Lanjut Belanja</a>
                    <a href="checkout.php" class="checkout-btn">Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const id_keranjang = this.dataset.id;
                const newQuantity = parseInt(this.value);
                const price = parseFloat(this.closest('.cart-item').querySelector('.unit-price').dataset.price);
                const itemTotalElement = this.closest('.cart-item').querySelector('.item-total');
                
                // Update via AJAX
                fetch('update-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_keranjang=${id_keranjang}&quantity=${newQuantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        itemTotalElement.textContent = 'Rp' + data.itemTotal.toLocaleString('id-ID');
                        document.getElementById('cart-total').textContent = 'Rp' + data.grandTotal.toLocaleString('id-ID');
                    } else {
                        alert(data.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui keranjang');
                });
            });
        });
    });
    </script>

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