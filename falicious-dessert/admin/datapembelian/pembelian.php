<?php
// Contoh data statis, ganti dengan data dari database jika perlu
$pembelian = [
    [
        "id" => 4,
        "tanggal" => "2024-06-23",
        "produk" => "Black Mamba",
        "jumlah" => 40,
        "harga" => 176000,
        "total" => 7040000,
        "supplier" => "Angga Dwi",
        "status" => "Lunas"
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pembelian Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Pembelian Barang</h2>

    <table>
        <thead>
            <tr>
                <th>Id Pembayaran</th>
                <th>Tgl Pembelian</th>
                <th>Nama Produk</th>
                <th>Jumlah Produk</th>
                <th>Harga Produk</th>
                <th>Total</th>
                <th>Nama Supplier</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pembelian as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['tanggal'] ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td><?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><?= number_format($item['total'], 0, ',', '.') ?></td>
                <td><?= $item['supplier'] ?></td>
                <td><?= $item['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button class="back-btn">Back</button>
</body>
</html>