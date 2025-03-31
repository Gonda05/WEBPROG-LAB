<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: http://localhost/admin_krs/admin/login/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
</head>
<body>
    <h2>Laporan Jadwal</h2>
    <ul>
        <?php if ($_SESSION['role'] === 'mahasiswa') : ?>
            <li><a href="mahasiswa.php">Laporan Jadwal Mahasiswa</a></li>
        <?php elseif ($_SESSION['role'] === 'dosen') : ?>
            <li><a href="dosen.php">Laporan Jadwal Dosen</a></li>
        <?php else : ?>
            <li>Anda tidak memiliki akses ke laporan ini.</li>
        <?php endif; ?>
    </ul>
    <a href="../login/menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
