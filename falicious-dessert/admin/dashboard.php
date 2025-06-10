<?php
// Dummy data – nanti bisa diganti query dari database
$jumlah_produk = 15;
$jumlah_pesanan = 0;
$jumlah_pelanggan = 5;
$total_pendapatan = 0;
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
        <img src="logo_dessert-removebg-preview.png" alt="logo">
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
          <img src="profile.jpg" alt="Admin">
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