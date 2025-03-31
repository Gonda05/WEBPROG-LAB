<?php
include '../config.php';

$id = $_GET['id'];
$query = "SELECT * FROM krs WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_matkul = $_POST['kode_matkul'];
    $nik_dosen = $_POST['nik_dosen'];
    $nim_mahasiswa = $_POST['nim_mahasiswa'];
    $hari_matkul = $_POST['hari_matkul'];
    $ruangan = $_POST['ruangan'];

    $query = "UPDATE krs SET kode_matkul='$kode_matkul', nik_dosen='$nik_dosen', nim_mahasiswa='$nim_mahasiswa', hari_matkul='$hari_matkul', ruangan='$ruangan' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data untuk dropdown
$matkul = mysqli_query($conn, "SELECT * FROM matakuliah");
$dosen = mysqli_query($conn, "SELECT * FROM dosen");
$mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit KRS</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Edit KRS</h2>
    <form method="POST">
        <label>Mata Kuliah:</label>
        <select name="kode_matkul">
            <?php while ($row = mysqli_fetch_assoc($matkul)) : ?>
                <option value="<?= $row['kode_matkul']; ?>" <?= ($data['kode_matkul'] == $row['kode_matkul']) ? 'selected' : ''; ?>><?= $row['nama_matkul']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Dosen Pengajar:</label>
        <select name="nik_dosen">
            <?php while ($row = mysqli_fetch_assoc($dosen)) : ?>
                <option value="<?= $row['nik']; ?>" <?= ($data['nik_dosen'] == $row['nik']) ? 'selected' : ''; ?>><?= $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Mahasiswa:</label>
        <select name="nim_mahasiswa">
            <?php while ($row = mysqli_fetch_assoc($mahasiswa)) : ?>
                <option value="<?= $row['nim']; ?>" <?= ($data['nim_mahasiswa'] == $row['nim']) ? 'selected' : ''; ?>><?= $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Hari:</label>
        <input type="text" name="hari_matkul" value="<?= $data['hari_matkul']; ?>" required>
        <label>Ruangan:</label>
        <input type="text" name="ruangan" value="<?= $data['ruangan']; ?>"
        <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>