<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];

    $query = "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', tahun_masuk='$tahun_masuk', alamat='$alamat', telp='$telp' WHERE nim='$nim'";
    
    if (mysqli_query($conn, $query)) {
        setFlash("Data $nim berhasil diedit!", "info");
        header("Location: /menu/index.php?page=mahasiswa");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

ob_start();
?>

<form method="POST" action="/menu/mahasiswa/edit.php" class="space-y-4">
    <input type="hidden" name="nim" value="<?= $nim; ?>">
    <div>
        <label class="block">NIM:</label>
        <input type="text" value="<?= $nim; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama:</label>
        <input type="text" name="nama" value="<?= $row['nama']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">jurusan:</label>
        <input type="text" name="jurusan" value="<?= $row['jurusan']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Tahun Masuk:</label>
        <input type="number" name="tahun_masuk" value="<?= $row['tahun_masuk']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Alamat:</label>
        <textarea name="alamat" required class="border rounded p-2 w-full"><?= $row['alamat']; ?></textarea>
    </div>
    <div>
        <label class="block">Telepon:</label>
        <input type="text" name="telp" value="<?= $row['telp']; ?>" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
