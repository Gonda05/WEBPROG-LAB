<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (isset($_GET['kode_matkul'])) {
    $kode = $_GET['kode_matkul'];
    $query = "SELECT * FROM matakuliah WHERE kode_matkul='$kode'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];

    $query = "UPDATE matakuliah SET nama_matkul='$nama_matkul', sks='$sks', semester='$semester' WHERE kode_matkul='$kode'";
    
    if (mysqli_query($conn, $query)) {
        setFlash("Data mata kuliah berhasil diedit!", "info");
        header("Location: ../index.php?page=matakuliah");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

ob_start();
?>

<form method="POST" action="./matakuliah/edit.php" class="space-y-4">
    <input type="hidden" name="kode_matkul" value="<?= $kode; ?>">
    <div>
        <label class="block">Kode Mata Kuliah:</label>
        <input type="text" value="<?= $kode; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama Mata Kuliah:</label>
        <input type="text" name="nama_matkul" value="<?= $row['nama_matkul']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">SKS:</label>
        <input type="number" name="sks" value="<?= $row['sks']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Semester:</label>
        <input type="number" name="semester" value="<?= $row['semester']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
