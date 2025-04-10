<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $query = "SELECT * FROM dosen WHERE nik='$nik'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $telp = $_POST['telp'];

    $query = "UPDATE dosen SET nama='$nama', gelar='$gelar', lulusan='$lulusan', telp='$telp' WHERE nik='$nik'";
    
    if (mysqli_query($conn, $query)) {
        $msg= $nik." berhasil diedit!";
        setFlash($msg, "info");
        header("Location: ../index.php?page=dosen");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$modal_id = 'editDosenModal';
$modal_title = 'Edit Dosen';
ob_start();

?>

<form method="POST" action="/menu/dosen/edit.php" class="space-y-4">
    <input type="hidden" name="nik" value="<?= $nik; ?>">
    <div>
        <label class="block">NIK:</label>
        <input type="text" value="<?= $nik; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama:</label>
        <input type="text" name="nama" value="<?= $row['nama']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Gelar:</label>
        <input type="text" name="gelar" value="<?= $row['gelar']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Lulusan:</label>
        <input type="text" name="lulusan" value="<?= $row['lulusan']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Telepon:</label>
        <input type="text" name="telp" value="<?= $row['telp']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>

