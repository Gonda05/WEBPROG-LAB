<?php
include '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Ambil NIK terakhir dari database
$query_last_nik = "SELECT nik FROM dosen ORDER BY nik DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_nik);
$row = mysqli_fetch_assoc($result);

if ($row) {
    // Ambil angka dari NIK terakhir dan tambahkan 1
    $last_nik = $row['nik']; // Misalnya "D010"
    $number = (int) filter_var($last_nik, FILTER_SANITIZE_NUMBER_INT); // Ambil angka "10"
    $new_nik = "D" . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Hasil: "D011"
} else {
    $new_nik = "D001"; // Jika belum ada data, mulai dari D001
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $telp = $_POST['telp'];
    $user_input = $_SESSION['username'];

    $query = "INSERT INTO dosen (nik, nama, gelar, lulusan, telp, user_input) VALUES ('$new_nik', '$nama', '$gelar', '$lulusan', '$telp', '$user_input')";
    
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
    <title>Tambah Dosen</title>
</head>
<body>
    <h2>Tambah Dosen</h2>
    <form method="POST">
        <label>NIK:</label><br>
        <input type="text" name="nik" value="<?= $new_nik; ?>" readonly><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Gelar:</label><br>
        <input type="text" name="gelar" required><br>
        <label>Lulusan:</label><br>
        <input type="text" name="lulusan" required><br>
        <label>Telepon:</label><br>
        <input type="text" name="telp" required><br><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
