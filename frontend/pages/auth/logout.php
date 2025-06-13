<?php
session_start();

// Hapus semua cookie terkait
$cookie_params = session_get_cookie_params();
setcookie('id_user', '', time() - 3600, '/');
setcookie(session_name(), '', time() - 3600, '/');

// Hapus semua session
$_SESSION = array();
session_destroy();

// Redirect ke halaman login
header('Location: http://localhost/app_dessert/frontend/pages/auth/login.php');
exit();