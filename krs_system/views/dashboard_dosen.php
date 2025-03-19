<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dosen') {
    header("Location: ../public/login.php?error=Silakan login terlebih dahulu");
    exit();
}

$conn = new mysqli("localhost", "root", "", "krs_system");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dosen
$dosen_id = $_SESSION['user_id'];
$dosen_query = $conn->query("SELECT * FROM dosen WHERE id = '$dosen_id'");
$dosen = $dosen_query->fetch_assoc();

// Ambil notifikasi
$notifikasi_query = $conn->query("SELECT * FROM notifikasi WHERE penerima_id = '$dosen_id'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Dashboard Dosen</h2>
    <nav>
        <ul>
            <li><a href="?menu=profil">Informasi Pribadi</a></li>
            <li><a href="?menu=matkul">Manajemen Mata Kuliah</a></li>
            <li><a href="?menu=mahasiswa">Manajemen Mahasiswa</a></li>
            <li><a href="?menu=penilaian">Penilaian & Evaluasi</a></li>
            <li><a href="?menu=administrasi">Administrasi Akademik</a></li>
            <li><a href="?menu=penelitian">Penelitian & Publikasi</a></li>
        </ul>
    </nav>

    <div class="content">
        <?php
        if (isset($_GET['menu'])) {
            $menu = $_GET['menu'];
            include "$menu.php";
        } else {
            echo "<p>Silakan pilih menu di atas.</p>";
        }
        ?>
    </div>

    <li><a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');">Logout</a></li>

</body>
</html>

<?php $conn->close(); ?>
