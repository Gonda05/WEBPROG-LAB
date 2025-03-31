<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_matkul = $_POST['kode_matkul'];
    $nik_dosen = $_POST['nik_dosen'];
    $nim_mahasiswa = $_POST['nim_mahasiswa'];
    $hari_matkul = $_POST['hari_matkul'];
    $ruangan = $_POST['ruangan'];
    $user_input = "admin";

    $query = "INSERT INTO krs (kode_matkul, nik_dosen, nim_mahasiswa, hari_matkul, ruangan, user_input) 
              VALUES ('$kode_matkul', '$nik_dosen', '$nim_mahasiswa', '$hari_matkul', '$ruangan', '$user_input')";

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
    <title>Tambah KRS</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Tambah KRS</h2>
    <form method="POST">
        <label>Mata Kuliah:</label>
        <select name="kode_matkul">
            <?php while ($row = mysqli_fetch_assoc($matkul)) : ?>
                <option value="<?= $row['kode_matkul']; ?>"><?= $row['nama_matkul']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Dosen Pengajar:</label>
        <select name="nik_dosen">
            <?php while ($row = mysqli_fetch_assoc($dosen)) : ?>
                <option value="<?= $row['nik']; ?>"><?= $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Mahasiswa:</label>
        <select name="nim_mahasiswa">
            <?php while ($row = mysqli_fetch_assoc($mahasiswa)) : ?>
                <option value="<?= $row['nim']; ?>"><?= $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Hari:</label>
        <input type="text" name="hari_matkul" required>
        <label>Ruangan:</label>
        <input type="text" name="ruangan" required>
        <button type="submit">Simpan</button>
    </form>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>
</body>
</html>
