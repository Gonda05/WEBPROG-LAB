<?php
session_start();
require_once '../config/database.php'; // Pastikan path benar

$error = "";

// Jika sudah login, arahkan ke dashboard masing-masing
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

// Proses form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['email']); // Gunakan `username`, bukan `email`
    $password = $_POST['password'];

    try {
        // Koneksi database
        $pdo = new PDO("mysql:host=localhost;dbname=krs_system", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cek apakah username terdaftar
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // Ambil role langsung dari database

            // Arahkan ke dashboard berdasarkan role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../views/dashboard_admin.php");
                    break;
                case 'dosen':
                    header("Location: ../views/dashboard_dosen.php");
                    break;
                case 'mahasiswa':
                    header("Location: ../views/dashboard_mahasiswa.php");
                    break;
                default:
                    $error = "❌ Role tidak dikenali!";
            }
            exit();
        } else {
            $error = "❌ Username atau password salah!";
        }
    } catch (PDOException $e) {
        die("Koneksi database gagal: " . $e->getMessage());
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
        <label for="email">Username:</label>
        <input type="text" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
