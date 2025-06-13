<?php
session_start();

if (!isset($_COOKIE['id_user'])) {
    // Jika cookie tidak ditemukan, arahkan ke login
    header("Location: http://localhost/app_dessert/frontend/pages/auth/login.php");
    exit();
}
?>
