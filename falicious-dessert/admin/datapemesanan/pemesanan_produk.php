<?php
// Contoh array dummy (ganti dengan query dari database)
$pemesanan = [
    [
        "gambar" => "img/redvelvet.jpg",
        "produk" => "Lotus Dessert Box",
        "pemesan" => "Syifa A",
        "pembayaran" => "Rp. 65.000 (BRI)<br>dibayar 14/04/2025",
        "pengiriman" => "JNT<br>Kalialang, Kemangkon",
        "status" => "Pending"
    ],
    // Tambahkan data lainnya sesuai kebutuhan
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pemesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Pemesanan</h2>
    <div class="search-container">
        <input type="text" placeholder="Cari Data...">
        <button>Cari</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Produk</th>
                <th>Pembayaran</th>
                <th>Pengiriman</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pemesanan as $data): ?>
            <tr>
                <td><img src="<?= $data['gambar']; ?>" alt="produk" class="produk-img"></td>
                <td><?= $data['produk']; ?><br><small>dipesan oleh <?= $data['pemesan']; ?></small></td>
                <td><?= $data['pembayaran']; ?></td>
                <td><?= $data['pengiriman']; ?></td>
                <td><?= $data['status']; ?></td>
                <td>
                    <button class="delete-btn">Delete</button>
                    <button class="bukti-btn">Bukti transaksi</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="popupBukti" class="popup-container" style="display: none;">
        <div class="popup-content">
    <span class="close-btn" onclick="tutupPopup()">&times;</span>
    <img id="buktiGambar" src="" alt="Bukti Transaksi" class="popup-image">
  </div>
</div>


    <button class="back-btn">Back</button>
</body>
</html>