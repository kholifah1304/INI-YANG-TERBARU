<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_dessert";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo '<pre>';
print_r($_POST);
echo '</pre>';
if (
    isset($_POST['id']) &&
    isset($_POST['kategori']) &&
    isset($_POST['nama']) &&
    isset($_POST['stok']) &&
    isset($_POST['harga'])
) {
    $id       = $_POST['id'];
    $kategori = $_POST['kategori'];
    $nama     = $_POST['nama'];
    $stok     = $_POST['stok'];
    $harga    = $_POST['harga'];

    $sql = "UPDATE produk SET kategori = ?, nama = ?, stok = ?, harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssiii", $kategori, $nama, $stok, $harga, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil diperbarui!'); window.location='data_produk.php';</script>";
        } else {
            echo "Gagal memperbarui data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Query gagal disiapkan: " . $conn->error;
    }
} else {
    echo "Data tidak lengkap.";
}

$conn->close();
?>