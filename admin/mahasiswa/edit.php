<?php
include '../config.php';

$nim = $_GET['nim'];
$query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];

    $query = "UPDATE mahasiswa SET nama='$nama', tahun_masuk='$tahun_masuk', alamat='$alamat', telp='$telp' WHERE nim='$nim'";
    
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
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Edit Mahasiswa</h2>
    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
        <label>Tahun Masuk:</label>
        <input type="number" name="tahun_masuk" value="<?= $data['tahun_masuk']; ?>" required>
        <label>Alamat:</label>
        <textarea name="alamat" required><?= $data['alamat']; ?></textarea>
        <label>Telepon:</label>
        <input type="text" name="telp" value="<?= $data['telp']; ?>" required>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>
</body>
</html>
