<?php
session_start();
include "../../../koneksi.php";

header('Content-Type: application/json');

if (!isset($_COOKIE['id_user'])) {
    echo json_encode(['success' => false]);
    exit();
}

$id_user = $_COOKIE['id_user'];

try {
    $stmt = $koneksi->prepare("SELECT id_user, username, email FROM user WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $user['id_user'],
                'username' => $user['username'],
                'email' => $user['email']
            ]
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}