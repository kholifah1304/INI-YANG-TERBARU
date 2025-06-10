<?php 
// Dummy data
$pemesanan = [
    [
        "gambar" => "img/redvelvet.jpg",
        "produk" => "Lotus Dessert Box",
        "pemesan" => "Syifa A",
        "pembayaran" => "Rp. 65.000 (BRI)<br>dibayar 14/04/2025",
        "pengiriman" => "JNT<br>Kalialang, Kemangkon",
        "status" => "Pending",
        "bukti" => "img/bukti_pembayaran.jpg"
    ],
    [
        "gambar" => "img/coklat.jpg",
        "produk" => "Choco Lava",
        "pemesan" => "Dewi N",
        "pembayaran" => "Rp. 40.000 (BNI)<br>dibayar 10/04/2025",
        "pengiriman" => "JNE<br>Purwokerto",
        "status" => "Selesai",
        "bukti" => "img/bukti_coklat.jpg"
    ],
];

// Tangkap kata kunci dari form pencarian
$keyword = isset($_GET['keyword']) ? strtolower($_GET['keyword']) : "";

// Filter data jika ada keyword pencarian
if (!empty($keyword)) {
    $pemesanan = array_filter($pemesanan, function ($item) use ($keyword) {
        return strpos(strtolower($item['produk']), $keyword) !== false ||
               strpos(strtolower($item['pemesan']), $keyword) !== false ||
               strpos(strtolower(strip_tags($item['pengiriman'])), $keyword) !== false;
    });
}
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

    <!-- Form Pencarian -->
    <form method="GET" class="search-container">
        <input type="text" name="keyword" placeholder="Cari Data..." value="<?= htmlspecialchars($keyword); ?>">
        <button type="submit">Cari</button>
    </form>

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
            <?php if (!empty($pemesanan)): ?>
                <?php foreach ($pemesanan as $index => $data): ?>
                <tr>
                    <td><img src="<?= $data['gambar']; ?>" alt="produk" class="produk-img" width="100"></td>
                    <td><?= $data['produk']; ?><br><small>dipesan oleh <?= $data['pemesan']; ?></small></td>
                    <td><?= $data['pembayaran']; ?></td>
                    <td><?= $data['pengiriman']; ?></td>
                    <td><?= $data['status']; ?></td>
                    <td>
                        <button class="delete-btn" onclick="hapusData(<?= $index ?>)">Delete</button>
                        <button class="bukti-btn" onclick="tampilkanPopup('<?= $data['bukti']; ?>')">Bukti transaksi</button>
                    </td>

                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Popup Bukti -->
    <div id="popupBukti" class="popup-container" style="display: none;">
        <div class="popup-content">
            <span class="close-btn" onclick="tutupPopup()">&times;</span>
            <img id="buktiGambar" src="" alt="Bukti Transaksi" class="popup-image">
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back()">Back</button>

    <script>
        function tampilkanPopup(src) {
            document.getElementById('popupBukti').style.display = 'flex';
            document.getElementById('buktiGambar').src = src;
        }

        function tutupPopup() {
            document.getElementById('popupBukti').style.display = 'none';
            document.getElementById('buktiGambar').src = '';
        }

        function hapusData(index) {
            if (confirm("Yakin ingin menghapus data ini?")) {
                alert("Data ke-" + index + " berhasil dihapus (simulasi).");
            }
        }
    </script>
</body>
</html>
