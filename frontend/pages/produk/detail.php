<?php
session_start();
include "../../../koneksi.php";

if (isset($_COOKIE['id_user'])) {
    $id_user = $_COOKIE['id_user'];
} else {
    $id_user = '';
}

// Get product ID from URL
if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit();
}

$product_id = $_GET['id'];

// Fetch product details
$query_product = "SELECT p.*, k.nama_kategori 
                  FROM produk p 
                  JOIN kategori k ON p.id_kategori = k.id_kategori 
                  WHERE p.id_produk = ?";
$stmt = $koneksi->prepare($query_product);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: produk.php");
    exit();
}

$product = $result->fetch_assoc();

// Fetch related products (same category)
$query_related = "SELECT * FROM produk 
                  WHERE id_kategori = ? AND id_produk != ? 
                  LIMIT 5";
$stmt_related = $koneksi->prepare($query_related);
$stmt_related->bind_param("ii", $product['id_kategori'], $product_id);
$stmt_related->execute();
$related_products = $stmt_related->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETAIL PRODUK - <?= htmlspecialchars($product['nama_produk']) ?></title>
    <link rel="stylesheet" href="http://localhost/app_dessert/frontend/assets/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
</head>
<body>
    
    <header>
        <div class="header-left">
            <img src="http://localhost/app_dessert/frontend/assets/logo.png" alt="Logo" class="logo">
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
                <i class="fa fa-search search-icon"></i>
                <input type="text" placeholder="search product...">
            </div>
            <div class="icons">
                <a href="http://localhost/app_dessert/frontend/pages/order/keranjang.php"><span class="icon-cart">🛒</span></a>
                <a href="http://localhost/app_dessert/frontend/pages/auth/login.php"><span class="icon-user">👤</span></a>
            </div>
        </div>
    </header>

   <section class="product-detail">
   
        <div class="product-detail-container">
            <div class="product-image">
                <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>">
            </div>

            <div class="product-info">
                <h2><?= htmlspecialchars($product['nama_produk']) ?></h2>
                <p class="description"><?= htmlspecialchars($product['deskripsi']) ?></p>
                <p class="size">Size 8 x 8 cm</p>

                <div class="product-purchase">
                    <div class="quantity-control">
                        <label>Qty :</label>
                        <div class="quantity-buttons">
                            <button type="button" class="qty-minus">-</button>
                            <input type="text" id="quantity" value="1" min="1" max="<?= $product['stok'] ?>">
                            <button type="button" class="qty-plus">+</button>
                        </div>
                    </div>

                    <div class="price">
                        <span>Total : </span>
                        <p id="total-price">Rp<?= number_format($product['harga'], 0, ',', '.') ?>,00</p>
                    </div>
                </div>

                <div class="product-buttons">
                    <!-- <button class="add-to-cart" data-product-id="<?= $product['id_produk'] ?>">Add To Cart</button> -->
                        <a href="http://localhost/app_dessert/frontend/pages/order/pemesanan.php?product_id=<?= $product['id_produk'] ?>&quantity=1" id="buy-now-button">
        <button class="buy-now">Buy Now</button>
    </a>

                </div>
            </div>
        </div>
    </section>

    <main>
        <div class="line">
            <p>Produk Lainnya</p>
            <hr>
        </div>
    </main>
    
        <div class="products-container">
            <?php foreach ($related_products as $related): ?>
            <div class="product-card">
                <a href="detail.php?id=<?= $related['id_produk'] ?>">
                    <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($related['foto_produk']) ?>" alt="<?= htmlspecialchars($related['nama_produk']) ?>" class="product-image">
                </a>
                <div class="product-name"><?= htmlspecialchars($related['nama_produk']) ?></div>
                <div class="product-price">Rp<?= number_format($related['harga'], 0, ',', '.') ?>,00</div>
                <a href="detail.php?id=<?= $related['id_produk'] ?>"><button class="view-detail">View Detail</button></a>
            </div>
            <?php endforeach; ?>
        </div>

    <!-- <script>
          document.querySelector('.qty-minus').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            updateTotalPrice(quantity);
            updateBuyNowLink(quantity); // Tambahkan ini
        }
    });

    document.querySelector('.qty-plus').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity < <?= $product['stok'] ?>) {
            quantity++;
            quantityInput.value = quantity;
            updateTotalPrice(quantity);
            updateBuyNowLink(quantity); // Tambahkan ini
        }
    });

    function updateBuyNowLink(quantity) {
        const buyNowButton = document.getElementById('buy-now-button');
        buyNowButton.href = `http://localhost/app_dessert/frontend/pages/order/pemesanan.php?product_id=<?= $product['id_produk'] ?>&quantity=${quantity}`;
    }
    

        // Add to cart functionality
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantity = document.getElementById('quantity').value;
            const popup = document.getElementById('popup');
            
            // AJAX request to add to cart
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
    console.log(data); // << Tambahkan ini
    if (data.success) {
        popup.style.display = "block";
        setTimeout(() => {
            popup.style.display = "none";
        }, 3000);
    } else {
        alert("Gagal menambahkan ke keranjang: " + data.message);
    }
});

        });

        function closePopup() {
            document.getElementById('popup').style.display = "none";
        }

        // Product slider
        const container = document.querySelector('.products-container');
        const tombolKanan = document.querySelector('.geser-kanan');
        const tombolKiri = document.querySelector('.geser-kiri');

        tombolKanan.addEventListener('click', () => {
            container.scrollBy({ left: 400, behavior: 'smooth' });
        });

        tombolKiri.addEventListener('click', () => {
            container.scrollBy({ left: -400, behavior: 'smooth' });
        });
    </script> -->

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
        <p class="footer-note">created by <span>SLDessert</span> | all rights reserved</p>
    </footer>
</body>
</html>