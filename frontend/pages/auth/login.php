<?php
session_start();
include "../../koneksi.php"; // Sesuaikan path ke file koneksi Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Gunakan prepared statement untuk mencegah SQL injection
    $sql = "SELECT id_user, username, password, role FROM user WHERE username = ? OR email = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ss", $username, $username); // Gunakan username dua kali karena bisa jadi username atau email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
if (password_verify($password, $user["password"])) {
    // Set cookie
    $cookie_name = "id_user";
    $cookie_value = $user["id_user"];
    $cookie_expiry = time() + (86400 * 30); // 30 hari
    setcookie($cookie_name, $cookie_value, $cookie_expiry, "/");

    // Cek role dan redirect sesuai
    if ($user["role"] === "admin") {
        header("Location: ../../../falicious-dessert/admin/dashboard.php"); // arahkan ke dashboard admin
    } else {
        header("Location: ../home.php"); // pengguna biasa ke home
    }
    exit();
}
 else {
            // Password tidak cocok
            $error = "Username atau password salah.";
        }
    } else {
        // User tidak ditemukan
        $error = "Username atau password salah.";
    }

    $stmt->close();
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/auth.css">
    <title>Log In</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="../auth/signup.php" class="back-button">&#8249;</a>
                <h1 style="margin-top: 1rem;">LOG IN</h1>
            </div>
            <div>
                <img src="http://localhost/app_dessert/frontend/assets/logo.png" alt="" class="logo">
            </div>
        </div>

        <form class="login-form" method="POST" action="">
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <label for="username">Username or Email Address</label>
            <input type="text" name="username" id="username" placeholder="Username or Email Address" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" class="login-button">Log In</button>
        </form>

        <p class="sign-up">Belum Memiliki Akun? <a href="../auth/signup.php">Sign Up</a></p>
    </div>
</body>
</html>
