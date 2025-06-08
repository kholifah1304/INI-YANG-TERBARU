<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pembelian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="simpan_pembelian.php" method="POST">
            <input type="date" name="tanggal" required>
            <input type="text" name="nama_produk" placeholder="Nama Produk" required>
            <input type="number" name="jumlah" placeholder="Jumlah Produk" required>
            <input type="number" name="harga" placeholder="Harga/pcs" required>
            <input type="number" name="total" placeholder="Total" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="status" placeholder="Status" required>
            
            <div class="button-group">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="datapembelian.php" class="btn-lihat">Lihat Data Pembelian</a>
            </div>
        </form>
    </div>
</body>
</html>
