<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "db_dessert");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$query = "SELECT * FROM user";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Customer</h2>

    <div class="search-box">
        <input type="text" placeholder="Cari Data..." />
        <button><i class="search-icon">🔍</i></button>
    </div>

<table>
    <thead>
        <tr>
            <th>Id User</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No.Telp</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_user'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['no_telp'] ?></td>
            <td><?= $row['alamat'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <a href="../dashboard.php" class="back-button">Back</a>
</body>
</html>