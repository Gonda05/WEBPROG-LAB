<?php
session_start();
require '../config.php'; // File koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        $_SESSION['error'] = "Harap isi username dan password!";
        header("Location: index.php");
        exit();
    }
    session_unset();                                    // Clear old session data
    session_regenerate_id(true);    // New session ID for security

    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Query ke database untuk mendapatkan user berdasarkan username
    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../menu");
            exit();
        } else {
            $_SESSION['error'] = "Username atau password salah!";
        }
    } else {
        $_SESSION['error'] = "Username atau password salah!";
    }
    
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
