    <?php
    include "../../koneksi.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Gunakan prepared statement untuk mencegah SQL injection
        $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);

        // Periksa apakah prepare() berhasil
        if ($stmt === false) {
            die("Prepare failed: " . $koneksi->error);
        }

        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../auth/login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
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
    <title>SIGN UP</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="../../pages/auth/login.php" class="back-button">&#8249;</a>
                <h1 style="margin-top: 1rem;">SIGN UP</h1>
            </div>
            <div>
                <img src="http://localhost/app_dessert/frontend/assets/logo.png" alt="" class="logo">
            </div>
        </div>

        <form class="login-form" action="signup.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit" class="login-button">Sign Up</button>
        </form>
        <p class="sign-up">Sudah Memiliki Akun? <a href="../../pages/auth/login.php">Log In</a></p>
    </div>
</body>
</html>
