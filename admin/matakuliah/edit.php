<?php
include '../config.php';

$kode_matkul = $_GET['kode_matkul'];
$query = "SELECT * FROM matakuliah WHERE kode_matkul='$kode_matkul'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];

    $query = "UPDATE matakuliah SET nama_matkul='$nama_matkul', sks='$sks', semester='$semester' WHERE kode_matkul='$kode_matkul'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mata Kuliah</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Edit Mata Kuliah</h2>
    <form method="POST">
        <label>Nama Mata Kuliah:</label>
        <input type="text" name="nama_matkul" value="<?= $data['nama_matkul']; ?>" required>
        <label>SKS:</label>
        <input type="number" name="sks" value="<?= $data['sks']; ?>" required>
        <label>Semester:</label>
        <input type="number" name="semester" value="<?= $data['semester']; ?>" required>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>
</body>
</html>
