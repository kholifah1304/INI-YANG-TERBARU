<?php
    include "../../../koneksi.php";

    if (isset($_COOKIE['id_user'])) {
        $id_user = $_COOKIE['id_user'];
    } else {
        $id_user = '';
    }

    // Fetch categories
    $query_kategori = "SELECT * FROM kategori";
    $result_kategori = mysqli_query($koneksi, $query_kategori);
    $kategori = mysqli_fetch_all($result_kategori, MYSQLI_ASSOC);

    // Fetch classic dessert products (assuming id_kategori 1 is classic)
    $query_classic = "SELECT * FROM produk WHERE id_kategori = 3";
    $result_classic = mysqli_query($koneksi, $query_classic);
    $classic_products = mysqli_fetch_all($result_classic, MYSQLI_ASSOC);

    // Fetch fruit dessert products (assuming id_kategori 2 is fruit)
    $query_fruit = "SELECT * FROM produk WHERE id_kategori = 4";
    $result_fruit = mysqli_query($koneksi, $query_fruit);
    $fruit_products = mysqli_fetch_all($result_fruit, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUK</title>
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
                <i class="fa fa-search search-icon"></i>
                <input type="text" placeholder="search product...">
            </div>
            <div class="icons">

                <a href="http://localhost/app_dessert/frontend/pages/auth/login.php"><span class="icon-user">👤</span></a>
            </div>
        </div>
    </header>
    
    <main>
        <div class="line">
            <p>KATEGORI</p>
            <hr>
        </div>
    </main>

    <div class="kategori-container">
        <?php foreach ($kategori as $kat): ?>
        <div class="kategori-card">
            <div class="kategori-image-wrapper">
                <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($kat['foto']) ?>" alt="<?= htmlspecialchars($kat['nama_kategori']) ?>" class="kategori-image">
                <div class="kategori-name"><?= htmlspecialchars($kat['nama_kategori']) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <main>
        <div class="line">
            <p>CLASSIC DESSERT BOX</p>
            <hr>
        </div>
    </main>

    <div class="products-wrapper">
        <button class="geser-kiri">←</button>

        <div class="products-container">
            <?php foreach ($classic_products as $product): ?>
            <div class="product-card">
                <a href="http://localhost/app_dessert/frontend/pages/produk/detail.php?id=<?= $product['id_produk'] ?>">
                    <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>" class="product-image">
                </a>
                <div class="product-name"><?= htmlspecialchars($product['nama_produk']) ?></div>
                <div class="product-price">Rp<?= number_format($product['harga'], 0, ',', '.') ?>,00</div>
            </div>
            <?php endforeach; ?>
        </div>

        <button class="geser-kanan">→</button>
    </div>

    <main>
        <div class="line">
            <p>FRUIT DESSERT BOX</p>
            <hr>
        </div>
    </main>

    <div class="products-wrapper">
        <button class="geser-kiri">←</button>

        <div class="products-container">
            <?php foreach ($fruit_products as $product): ?>
            <div class="product-card">
                <a href="http://localhost/app_dessert/frontend/pages/produk/detail.php?id=<?= $product['id_produk'] ?>">
                    <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>" class="product-image">
                </a>
                <div class="product-name"><?= htmlspecialchars($product['nama_produk']) ?></div>
                <div class="product-price">Rp<?= number_format($product['harga'], 0, ',', '.') ?>,00</div>
            </div>
            <?php endforeach; ?>
        </div>

        <button class="geser-kanan">→</button>
    </div>

    <script>
        const container = document.querySelectorAll('.products-container');
        const tombolKanan = document.querySelectorAll('.geser-kanan');
        const tombolKiri = document.querySelectorAll('.geser-kiri');

        tombolKanan.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                container[index].scrollBy({ left: 400, behavior: 'smooth' });
            });
        });

        tombolKiri.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                container[index].scrollBy({ left: -400, behavior: 'smooth' });
            });
        });
    </script>

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.554256046068!2d109.34410847357361!3d-7.403735972900789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6559b9ff8d3795%3A0xa58daaef273f4e44!2sSMK%20Negeri%201%20Purbalingga!5e0!3m2!1sid!2sid!4v1716216993817!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <p class="footer-note">created by <span>SLDessert </span> | all rights reserved</p>
    </footer>
    
</body>
</html>