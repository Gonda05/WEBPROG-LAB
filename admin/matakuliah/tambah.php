<?php
include '../config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Ambil kode matkul terakhir dari database
$query_last_kode = "SELECT kode_matkul FROM matakuliah ORDER BY kode_matkul DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_kode);
$row = mysqli_fetch_assoc($result);

if ($row) {
    // Ambil angka dari kode terakhir dan tambahkan 1
    $last_kode = (int)substr($row['kode_matkul'], 2); // Misal "MK010" → ambil "010"
    $new_kode = "MK" . str_pad($last_kode + 1, 3, "0", STR_PAD_LEFT); // Hasil: "MK011"
} else {
    $new_kode = "MK001"; // Jika belum ada data, mulai dari "MK001"
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $user_input = $_SESSION['username']; // Sesuai user yang login

    $query = "INSERT INTO matakuliah (kode_matkul, nama_matkul, sks, semester, user_input) 
              VALUES ('$new_kode', '$nama_matkul', '$sks', '$semester', '$user_input')";

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
    <title>Tambah Mata Kuliah</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Tambah Mata Kuliah</h2>
    <form method="POST">
        <label>Kode Matkul:</label>
        <input type="text" name="kode_matkul" value="<?= $new_kode; ?>" readonly>
        <label>Nama Mata Kuliah:</label>
        <input type="text" name="nama_matkul" required>
        <label>SKS:</label>
        <input type="number" name="sks" required>
        <label>Semester:</label>
        <input type="number" name="semester" required>
        <button type="submit">Simpan</button>
    </form>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>
</body>
</html>
