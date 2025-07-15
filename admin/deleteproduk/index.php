<?php
// Contoh data produk (ganti dengan dari database jika perlu)
$produk = [
  ["id" => 0, "nama" => "Chocolate Lava Crunch", "stok" => 30, "harga" => "Rp 65.000,00", "kategori" => "Brownies Cake"],
  ["id" => 1, "nama" => "Red Velvet Cream Cheese Brownies", "stok" => 45, "harga" => "Rp 65.000,00", "kategori" => "Brownies Cake"],
  ["id" => 2, "nama" => "Honey Date Brownies", "stok" => 43, "harga" => "Rp 65.000,00", "kategori" => "Brownies Cake"],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Data Produk</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h2>Data Produk</h2>
    <button class="input-button">Input Produk</button>

    <table>
      <thead>
        <tr>
          <th>Id Produk</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produk as $item): ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['nama'] ?></td>
            <td><?= $item['stok'] ?></td>
            <td><?= $item['harga'] ?></td>
            <td><?= $item['kategori'] ?></td>
            <td>
              <a class="edit-button" href="edit.php?id=<?= $item['id'] ?>">Edit</a>
              <button class="delete-button" onclick="showDeletePopup(<?= $item['id'] ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button class="back-button">Back</button>
  </div>

  <!-- Popup Delete -->
  <div id="deletePopup" class="popup-overlay">
    <div class="popup-box">
      <p>Apakah Anda yakin ingin menghapus produk ini?</p>
      <div class="popup-actions">
        <a id="confirmDelete" class="popup-ok" href="#">Oke</a>
        <button onclick="hideDeletePopup()">Cancel</button>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
