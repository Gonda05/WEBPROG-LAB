x<?php
session_start();
include '../config.php'; // Koneksi ke database

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Proses penambahan user baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = trim($_POST['role']);
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $nim_nik = trim($_POST['nim_nik']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash password

    // Validasi input
    if (empty($role) || empty($nama) || empty($username) || empty($nim_nik) || empty($_POST['password'])) {
        $_SESSION['error'] = "Semua kolom harus diisi!";
        header("Location: users.php");
        exit();
    }

    // Validasi username (hanya huruf)
    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $_SESSION['error'] = "Username hanya boleh berisi huruf!";
        header("Location: users.php");
        exit();
    }

    // Validasi NIM/NIK sesuai dengan role
    if ($role === "mahasiswa") {
        $query = "SELECT nim FROM mahasiswa WHERE nim = ?";
    } elseif ($role === "dosen") {
        $query = "SELECT nik FROM dosen WHERE nik = ?";
    } else {
        $query = null; // Admin tidak perlu NIM/NIK
    }

    if ($query) {
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nim_nik);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if (!$data) {
                $_SESSION['error'] = "NIM/NIK tidak ditemukan di database $role!";
                header("Location: users.php");
                exit();
            }
        }
    }

    // Pastikan username unik
    $checkQuery = "SELECT username FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($result)) {
            $_SESSION['error'] = "Username sudah digunakan! Silakan pilih username lain.";
            header("Location: users.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    // Masukkan data ke database
    $insertQuery = "INSERT INTO users (role, nama, username, nim_nik, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $role, $nama, $username, $nim_nik, $password);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Akun berhasil dibuat!";
        } else {
            $_SESSION['error'] = "Gagal membuat akun!";
        }
        mysqli_stmt_close($stmt);
    }

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <script>
        function toggleNIMNIKField() {
            var role = document.getElementById("role").value;
            var nimNIKField = document.getElementById("nim_nik");
            var nimNIKLabel = document.getElementById("nim_nik_label");

            if (role === "admin") {
                nimNIKField.style.display = "none";
                nimNIKLabel.style.display = "none";
                nimNIKField.removeAttribute("required");
            } else {
                nimNIKField.style.display = "block";
                nimNIKLabel.style.display = "block";
                nimNIKField.setAttribute("required", "required");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Tambah User Baru</h2>

        <?php if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>

        <form method="POST">
            <label for="role">Pilih Role:</label>
            <select name="role" id="role" onchange="toggleNIMNIKField()">
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="admin">Admin</option>
            </select>

            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" placeholder="Nama Lengkap" required>

            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Masukkan Username (Hanya Huruf)" required>

            <label id="nim_nik_label" for="nim_nik">NIM/NIK:</label>
            <input type="text" name="nim_nik" id="nim_nik" placeholder="Masukkan NIM/NIK" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Buat Akun</button>
        </form>
        <a href="../login/menu_utama.php">Kembali ke Menu Utama</a>
    </div>

    <script>
        toggleNIMNIKField(); // Panggil saat halaman dimuat
    </script>
</body>
</html>
