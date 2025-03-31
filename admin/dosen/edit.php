<?php
include '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $query = "SELECT * FROM dosen WHERE nik='$nik'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $telp = $_POST['telp'];

    $query = "UPDATE dosen SET nama='$nama', gelar='$gelar', lulusan='$lulusan', telp='$telp' WHERE nik='$nik'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>
</head>
<body>
    <h2>Edit Dosen</h2>
    <form method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $row['nama']; ?>" required><br>
        <label>Gelar:</label><br>
        <input type="text" name="gelar" value="<?= $row['gelar']; ?>" required><br>
        <label>Lulusan:</label><br>
        <input type="text" name="lulusan" value="<?= $row['lulusan']; ?>" required><br>
        <label>Telepon:</label><br>
        <input type="text" name="telp" value="<?= $row['telp']; ?>" required><br><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
