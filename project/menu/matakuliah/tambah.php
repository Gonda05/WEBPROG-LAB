<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

$query_last_kode = "SELECT kode_matkul FROM matakuliah ORDER BY kode_matkul DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_kode);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $last_kode = (int)substr($row['kode_matkul'], 2); // MK010 → 10
    $new_kode = "MK" . str_pad($last_kode + 1, 3, "0", STR_PAD_LEFT);
} else {
    $new_kode = "MK001";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $user_input = $_SESSION['username'];

    $query = "INSERT INTO matakuliah (kode_matkul, nama_matkul, sks, semester, user_input) 
              VALUES ('$new_kode', '$nama_matkul', '$sks', '$semester', '$user_input')";

    if (mysqli_query($conn, $query)) {
        setFlash("Mata kuliah berhasil ditambahkan!", "success");
        header("Location: /menu/index.php?page=matakuliah");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

ob_start();
?>

<form method="POST" action="/menu/matakuliah/tambah.php" class="space-y-4">
    <div>
        <label class="block">Kode Mata Kuliah:</label>
        <input type="text" value="<?= $new_kode; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama Mata Kuliah:</label>
        <input type="text" name="nama_matkul" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">SKS:</label>
        <input type="number" name="sks" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Semester:</label>
        <input type="number" name="semester" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
