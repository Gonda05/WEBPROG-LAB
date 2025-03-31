<?php
session_start();
include '../config.php';

// Pastikan hanya mahasiswa yang bisa mengakses
if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../index.php");
    exit();
}

$nim = $_SESSION['nim']; // Ambil NIM dari sesi
$query = "SELECT krs.id, matakuliah.nama_matkul, matakuliah.sks, dosen.nama AS nama_dosen, krs.hari_matkul, krs.ruangan
          FROM krs 
          JOIN matakuliah ON krs.kode_matkul = matakuliah.kode_matkul
          JOIN dosen ON krs.nik_dosen = dosen.nik
          WHERE krs.nim_mahasiswa = '$nim'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Mahasiswa</title>
</head>
<body>
    <h2>Laporan Jadwal Kuliah</h2>
    <table border="1">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Dosen Pengajar</th>
            <th>Hari</th>
            <th>Ruangan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['nama_matkul']; ?></td>
            <td><?= $row['sks']; ?></td>
            <td><?= $row['nama_dosen']; ?></td>
            <td><?= $row['hari_matkul']; ?></td>
            <td><?= $row['ruangan']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Kembali</a>
</body>
</html>
