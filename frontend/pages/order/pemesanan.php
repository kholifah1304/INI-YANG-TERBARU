    <?php
    session_start();
    include "../../koneksi.php";

    // Ambil product_id dan quantity dari URL
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

    // Pastikan product_id ada
    if ($product_id === null) {
        // Redirect atau tampilkan pesan error
        echo "Product ID tidak valid.";
        exit;
    }



    // Ambil informasi produk dari database
    $query_product = "SELECT * FROM produk WHERE id_produk = ?";
    $stmt = $koneksi->prepare($query_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$stmt) {
    die("Prepare produk gagal: " . $koneksi->error);
}
if (!$stmt->execute()) {
    die("Eksekusi produk gagal: " . $stmt->error);
}


    if ($result->num_rows === 0) {
        // Redirect atau tampilkan pesan error
        echo "Produk tidak ditemukan.";
        exit;
    }

    $product = $result->fetch_assoc();

    // Hitung subtotal
    $subtotal = $product['harga'] * $quantity;
    $ongkir = 8000; // Contoh ongkir
    $total = $subtotal + $ongkir;
    ?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEMESANAN</title>
    <link rel="stylesheet" href="http://localhost/app_dessert/frontend/assets/pemesanan.css">
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

    <div class="popup-bri" id="popupBri">
        <div class="popup-content">
            <span class="close" onclick="closePopupBri()">&times;</span>
            <h2>Pembayaran via BRI</h2>
            <div class="popup-info">
                <p>No rekening: <strong>08987654321</strong> <button onclick="copyRek()">Salin</button></p>
                <p>Nama: <strong>ZAHRA</strong></p>
            </div>
            <p>Total: <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></p>
            <p>Batas pembayaran: <strong>24 jam</strong> setelah pesanan dibuat</p>
        </div>
    </div>
    

    <h2>Checkout</h2>
    <form action="proses_pemesanan.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
        <input type="hidden" name="quantity" value="<?= $quantity ?>">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat..." required>

        <label for="info">Informasi Tambahan</label>
        <textarea id="info" name="info" rows="4" placeholder="Informasi alamat lengkap..."></textarea>

        <label>Metode Pembayaran</label>
        <div class="form-metode">
            <button><img src="http://localhost/app_dessert/frontend/assets/dana.png" alt="Dana"></button>
            <button><img src="http://localhost/app_dessert/frontend/assets/bri.jpg" id="briLogo" alt="Bayar via BRI" style="cursor:pointer; width: 100px;"></button>
            <button><img src="http://localhost/app_dessert/frontend/assets/bca.png" alt="BCA"></button>
        </div>

        <label>Upload Bukti Pembayaran</label>
        <small class="wajib">*wajib diisi</small>
        <div class="upload-area">
            <p>Pilih file atau drop disini<br><small>Format: JPG, PNG, JPEG (max 2MB)</small></p>
            <input type="file" name="bukti" required>
        </div>

        <button type="submit" class="buatpesanan">Buat Pesanan</button>
    
        <label for="metode_pengiriman">Metode Pengiriman</label>
    <select name="metode_pengiriman" id="metode_pengiriman" required>
    <option value="JNE">JNE</option>
    <option value="J&T">J&T</option>
    <option value="Grab">Grab</option>
    <!-- Tambah sesuai kebutuhan -->
    </select>
    </form>

    <h2>Ringkasan Pesanan</h2>
    <div class="summary-container">
        <div class="summary-card">
            <div class="summary-item">
                <img src="http://localhost/app_dessert/frontend/assets/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>">
                <div class="summary-text">
                    <p class="summary-name"><?= htmlspecialchars($product['nama_produk']) ?></p>
                    <p class="summary-line">Harga: Rp<?= number_format($product['harga'], 0, ',', '.') ?> x <?= $quantity ?></p>
                </div>
            </div>
            <div class="summary-total">
                <div class="summary-line">
                    <span>Sub total:</span>
                    <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
                <div class="summary-line">
                    <span>Ongkir:</span>
                    <span>Rp<?= number_format($ongkir, 0, ',', '.') ?></span>
                </div>
                <div class="summary-line total-bold">
                    <span>Total:</span>
                    <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>
    

    <button type="submit" class="buatpesanan">Buat Pesanan</button>


   <script>
    const briLogo = document.getElementById("briLogo");
    const popupBri = document.getElementById("popupBri");

    briLogo.addEventListener("click", () => {
        popupBri.style.display = "block";
    });

    function closePopupBri() {
        popupBri.style.display = "none";
    }

    function copyRek() {
        const tempInput = document.createElement("input");
        tempInput.value = "08987654321";
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Nomor rekening disalin!");
    }

    // Menutup jika klik luar popup
    window.onclick = function(event) {
        if (event.target == popupBri) {
        popupBri.style.display = "none";
        }
    };
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.554256046068!2d109.34410847357361!3d-7.403735972900789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6559b9ff8d3795%3A0xa58daaef273f4e44!2sSMK%20Negeri%201%20Purbalingga!5e0!3m2!1sid!2sid!4v1716216993817!5m2!1sid!2sid"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>
        <p class="footer-note">created by <span> SLDessert </span> | all rights reserved</p>
    </footer>
    
</body>
</html>