<?php
    include "../../koneksi.php";

    if (isset($_COOKIE['id_user'])) {
        $id_user = $_COOKIE['id_user'];
    }else{
        $id_user = '';
    }


    
// Ambil produk best seller dari database
$query = "SELECT * FROM produk ORDER BY id_produk LIMIT 3"; // Anda bisa sesuaikan dengan kriteria best seller
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
    <div class="user-icon-container">
        <a href="#" class="icon-user" id="userIcon">👤</a>
        <div class="user-popup" id="userPopup">
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div class="user-details">
                    <span class="user-name" id="userName">Nama User</span>
                    <span class="user-email" id="userEmail">user@example.com</span>
                </div>
            </div>
            <div class="popup-actions">
                <a href="http://localhost/app_dessert/frontend/pages/auth/logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>
</div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div>
                <h1>ENJOY THE INCREDIBLE TASTE IN EVERY BITE</h1>
                <p>Berbagai varian rasa dessert box yang siap dinikmati</p>
                <a href="http://localhost/app_dessert/frontend/pages/produk/produk.php"><button>Shop Now</button></a>
            </div>

            <div>
                <img src="http://localhost/app_dessert/frontend/assets/desserthome.png" alt="">
            </div>
        </section>
    </main>

    <div class="line">
        <p>BEST SELLER</p>
        <hr>
    </div>

<div class="products-container">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
            <img src="../assets/<?= $row['foto_produk'] ?>" alt="<?= $row['nama_produk'] ?>" class="product-image">
            <a href="../../produk/detail.php?id=<?= $row['id_produk'] ?>"><div class="best-seller-tag">Best Seller</div></a>
            <div class="product-name"><?= $row['nama_produk'] ?></div>
            <div class="product-price">Rp<?= number_format($row['harga'], 2, ',', '.') ?></div>
        </div>
    <?php endwhile; ?>
</div>

    <section class="highlight-message">
        <div class="highlight-content">
            <p>
            Setiap hari ada alasan untuk bahagia, dan kami hadir untuk menambah manisnya hari-harimu. <br>
            Dessert box kami dibuat dengan bahan pilihan dan cinta di setiap lapisannya lembut, creamy dan penuh rasa yang bikin nagih. <br>
            Karena hidup terlalu singkat untuk melewatkan dessert seenak ini.
            </p>
            <a href="./produk/produk.php" class="highlight-button">Shop Now</a>
        </div>
    </section>

    <div class="line">
        <p>PESAN</p>
        <hr>
    </div>

    <section class="contact-form">
        <img src="http://localhost/app_dessert/frontend/assets/stobeligrape.png" class="fruit top-left" alt="">
        <img src="http://localhost/app_dessert/frontend/assets/mango.png" class="fruit bottom-right" alt="">
        <img src="http://localhost/app_dessert/frontend/assets/coklat.png" class="choco left" alt="">
        <img src="http://localhost/app_dessert/frontend/assets/coklat.png" class="choco right" alt="">

        <form action="#" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Kirim Pesan</button>
        </form>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.getElementById('userIcon');
    const userPopup = document.getElementById('userPopup');
    
    // Tampilkan popup saat ikon user diklik
    userIcon.addEventListener('click', function(e) {
        e.preventDefault();
        userPopup.style.display = userPopup.style.display === 'block' ? 'none' : 'block';
        
        // Jika user sudah login, ambil data user
        if (document.cookie.includes('id_user') && !userPopup.dataset.loaded) {
            fetchUserData();
        }
    });
    
    // Sembunyikan popup saat klik di luar
    document.addEventListener('click', function(e) {
        if (!userPopup.contains(e.target) && e.target !== userIcon) {
            userPopup.style.display = 'none';
        }
    });
    
    // Fungsi untuk mengambil data user
    function fetchUserData() {
        fetch('http://localhost/app_dessert/frontend/pages/auth/get-user-data.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('userName').textContent = data.name || 'User';
                    document.getElementById('userEmail').textContent = data.email || '';
                    userPopup.dataset.loaded = true;
                }
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
            });
    }
    
    // Periksa status login saat halaman dimuat
    if (document.cookie.includes('id_user')) {
        fetchUserData();
    } else {
        // Jika belum login, ubah ikon user menjadi link ke login
        userIcon.href = 'http://localhost/app_dessert/frontend/pages/auth/login.php';
        userIcon.onclick = null;
    }
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