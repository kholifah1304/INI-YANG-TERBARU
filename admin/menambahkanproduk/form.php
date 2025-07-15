<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Tambah Produk</h2>
        <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>

            <div class="row">
                <div>
                    <label>Stok</label>
                    <input type="number" name="stok" required>
                </div>
                <div>
                    <label>Harga</label>
                    <input type="number" name="harga" required>
                </div>
            </div>

            <div class="row">
                <div>
                    <label>Kategori</label>
                    <input type="text" name="kategori" required>
                </div>
                <div>
                    <label>Upload Image</label>
                    <input type="file" name="gambar" accept="image/*" required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit">Tambah</button>
                <a href="index.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>