<?php
include "../koneksi.php"; 

// Helper untuk debug query
function cekQuery($result, $koneksi) {
    if (!$result) {
        die("Query gagal: " . $koneksi->error);
    }
    return $result->fetch_assoc();
}

// Jumlah Produk
$result = $koneksi->query("SELECT COUNT(*) as total FROM produk");
$data = cekQuery($result, $koneksi);
$jumlah_produk = $data['total'];

// Jumlah Pesanan
$result = $koneksi->query("SELECT COUNT(*) as total FROM pesanan");
$data = cekQuery($result, $koneksi);
$jumlah_pesanan = $data['total'];

// Jumlah Pelanggan (user dengan role 'customer')
$result = $koneksi->query("SELECT COUNT(*) as total FROM user WHERE role = 'customer'");
$data = cekQuery($result, $koneksi);
$jumlah_pelanggan = $data['total'];

// Total Pendapatan
$result = $koneksi->query("SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'Selesai'");
$data = cekQuery($result, $koneksi);
$total_pendapatan = $data['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="sidebar">
    <div class="logo">
        <img src="http://app_dessert/falicious-dessert/admin/images/logo_dessert-removebg-preview.png" alt="logo">
        </div>
    <ul>
      <li class="active"><a href="#">Dashboard</a></li>
      <li><a href="dataproduk/data_produk.php">Data Produk</a></li>
      <li><a href="datapemesanan/pemesanan_produk.php">Pemesanan</a></li>
      <li><a href="datapembelian/pembelian.php">Pembelian</a></li>
      <li><a href="datacustomer/customer.php">Customer</a></li>
    </ul>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Dashboard</h1>
      <div class="search-profile">
        <input type="text" placeholder="search here" />
        <div class="profile">
          <img src="http://app_dessert/falicious-dessert/admin/images/profile.jpg" alt="Admin">
          <div>
            <strong>Admin</strong><br><small>Super admin</small>
          </div>
        </div>
      </div>
    </div>

    <div class="cards">
      <div class="card">
        <h2><?php echo $jumlah_produk; ?></h2>
        <p>Produk</p>
      </div>
      <div class="card">
        <h2><?php echo $jumlah_pesanan; ?></h2>
        <p>Pesanan</p>
      </div>
      <div class="card">
        <h2><?php echo $jumlah_pelanggan; ?></h2>
        <p>Pelanggan</p>
      </div>
      <div class="card">
        <h2>Rp<?php echo number_format($total_pendapatan, 2, ',', '.'); ?></h2>
        <p>Total Pendapatan</p>
      </div>
    </div>
  </div>
</body>
</html>