<?php
session_start();
require_once '../config/database.php'; // Pastikan path ini benar

// Periksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: ../views/dashboard_admin.php");
            exit();
        case 'dosen':
            header("Location: ../views/dashboard_dosen.php");
            exit();
        case 'mahasiswa':
            header("Location: ../views/dashboard_mahasiswa.php");
            exit();
    }
}

$error = "";

// Proses form jika ada input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email terdaftar
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = '';

        // Tentukan role berdasarkan domain email
        if (strpos($email, '@admin') !== false) {
            $_SESSION['role'] = 'admin';
            header("Location: ../views/dashboard_admin.php");
        } elseif (strpos($email, '@dosen') !== false) {
            $_SESSION['role'] = 'dosen';
            header("Location: ../views/dashboard_dosen.php");
        } elseif (strpos($email, '@mahasiswa') !== false) {
            $_SESSION['role'] = 'mahasiswa';
            header("Location: ../views/dashboard_mahasiswa.php");
        } else {
            $error = "❌ Role tidak dikenali!";
        }
        exit();
    } else {
        $error = "❌ Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login KRS System</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
