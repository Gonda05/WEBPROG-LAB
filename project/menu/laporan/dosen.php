<?php
session_start();
include '../config.php';

// Pastikan hanya dosen yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dosen') {
    header("Location: ../index.php");
    exit();
}

// Pastikan NIK tersedia dalam sesi sebelum menggunakannya
if (!isset($_SESSION['nik'])) {
    echo "Error: Data NIK tidak ditemukan dalam sesi.";
    exit();
}

$nik = $_SESSION['nik']; // Ambil NIK dari sesi

$query = "SELECT matakuliah.nama_matkul, matakuliah.sks, krs.hari_matkul, krs.ruangan 
          FROM krs 
          JOIN matakuliah ON krs.kode_matkul = matakuliah.kode_matkul
          WHERE krs.nik_dosen = '$nik'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Dosen</title>
</head>
<body>
    <h2>Laporan Jadwal Mengajar</h2>
    <?php if (mysqli_num_rows($result) > 0) : ?>
    <table border="1">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Hari</th>
            <th>Ruangan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_matkul']); ?></td>
            <td><?= htmlspecialchars($row['sks']); ?></td>
            <td><?= htmlspecialchars($row['hari_matkul']); ?></td>
            <td><?= htmlspecialchars($row['ruangan']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else : ?>
        <p>Tidak ada jadwal ditemukan.</p>
    <?php endif; ?>
    <a href="index.php">Kembali</a>
</body>
</html>
