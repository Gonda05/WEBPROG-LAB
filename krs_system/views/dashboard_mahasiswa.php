<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../public/login.php?error=Silakan login terlebih dahulu");
    exit();
}

$conn = new mysqli("localhost", "root", "", "krs_system");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data profil mahasiswa
$query_profil = $conn->query("SELECT * FROM mahasiswa WHERE id='{$_SESSION['user_id']}'");
$profil = $query_profil ? $query_profil->fetch_assoc() : null;

// Ambil 5 notifikasi terbaru
$query_notifikasi = $conn->query("SELECT * FROM notifikasi WHERE user_id='{$_SESSION['user_id']}' ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Mahasiswa</title>
</head>
<body>
    <h2>Dashboard Mahasiswa</h2>
    <nav>
         <ul>
    <li><a href="navigate_mahasiswa/profile.php">Informasi Pribadi</a></li>
    <li><a href="navigate_mahasiswa/krs.php">Manajemen Perkuliahan</a></li>
    <li><a href="navigate_mahasiswa/tugas.php">Tugas dan Ujian</a></li>
    <li><a href="navigate_mahasiswa/kehadiran.php">Kehadiran</a></li>
    <li><a href="navigate_mahasiswa/nilai.php">Nilai dan Evaluasi</a></li>
    <li><a href="navigate_mahasiswa/admin.php">Administrasi Akademik</a></li>
        </ul>


    </nav>

    <div>
        <li><a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');">Logout</a></li>
    </div>

    <section>
        <?php
        $menu = isset($_GET['menu']) ? $_GET['menu'] : 'profil';
        $file_path = "navigate_mahasiswa/{$menu}.php";

        if (file_exists($file_path)) {
            include $file_path;
        } else {
            echo "<p>Halaman tidak ditemukan.</p>";
        }
        ?>
    </section>
</body>
</html>

<?php $conn->close(); ?>
