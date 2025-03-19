<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../config/database.php'; // Pastikan path benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        // Query ke database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // Amankan session

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../views/dashboard_admin.php");
                    exit();
                case 'dosen':
                    header("Location: ../views/dashboard_dosen.php");
                    exit();
                case 'mahasiswa':
                    header("Location: ../views/dashboard_mahasiswa.php");
                    exit();
                default:
                    header("Location: login.php?error=Role tidak dikenali");
                    exit();
            }
        } else {
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
