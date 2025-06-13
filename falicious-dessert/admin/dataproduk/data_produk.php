<?php
include "../../../koneksi.php";

if (!$koneksi) {
  die("Koneksi ke database gagal.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Produk</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Data Produk</h1>
    <div class="top-bar">
      <input type="text" placeholder="Cari Data..." class="search-input" />
      <a href="form.php" class="input-btn">Input Produk</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Gambar</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT p.id_produk, p.foto_produk, p.nama_produk, p.stok, p.harga, p.deskripsi, k.nama_kategori 
                  FROM produk p 
                  JOIN kategori k ON p.id_kategori = k.id_kategori";

        $result = $koneksi->query($query);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
              <td><?= $row['id_produk'] ?></td>
              <td><img src="../uploads/<?= $row['foto_produk'] ?>" alt="Gambar Produk" width="60"></td>
              <td><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td><?= $row['stok'] ?></td>
              <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
              <td><?= $row['nama_kategori'] ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td>
                <a href="../editproduk/edit_produk.php?id=<?= $row['id_produk'] ?>" class="edit">Edit</a>
                <a href="../deleteproduk/delete.php?id=<?= $row['id_produk'] ?>" class="delete" onclick="return confirm('Yakin ingin menghapus produk ini?')">Delete</a>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <button class="back-btn" onclick="history.back()">Back</button>
  </div>
</body>
</html>
