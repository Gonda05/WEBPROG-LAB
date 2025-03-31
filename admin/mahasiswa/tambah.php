<?php
include '../config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Ambil NIM terakhir dari database
$query_last_nim = "SELECT nim FROM mahasiswa ORDER BY nim DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_nim);
$row = mysqli_fetch_assoc($result);

if ($row) {
    // Ambil angka dari NIM terakhir dan tambahkan 1
    $last_nim = $row['nim']; // Misalnya "20231030"
    $new_nim = (int)$last_nim + 1; // Hasil: "20231031"
} else {
    $new_nim = date('Y') . "1001"; // Jika belum ada data, mulai dari tahun sekarang + "1001"
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $user_input = $_SESSION['username']; // Sesuai user yang login

    $query = "INSERT INTO mahasiswa (nim, nama, tahun_masuk, alamat, telp, user_input) 
              VALUES ('$new_nim', '$nama', '$tahun_masuk', '$alamat', '$telp', '$user_input')";

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
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Tambah Mahasiswa</h2>
    <form method="POST">
        <label>NIM:</label>
        <input type="text" name="nim" value="<?= $new_nim; ?>" readonly>
        <label>Nama:</label>
        <input type="text" name="nama" required>
        <label>Tahun Masuk:</label>
        <input type="number" name="tahun_masuk" required>
        <label>Alamat:</label>
        <textarea name="alamat" required></textarea>
        <label>Telepon:</label>
        <input type="text" name="telp" required>
        <button type="submit">Simpan</button>
    </form>
    
    <!-- Tombol Kembali ke Menu Utama -->
    <br>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>
</body>
</html>
