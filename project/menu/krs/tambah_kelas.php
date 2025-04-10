<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_matkul = $_POST['kode_matkul'];
    $nik = $_POST['nik'];
    $hari_matkul = $_POST['hari_matkul'];
    $kelas_matkul = $_POST['kelas_matkul'];
    $ruang_matkul = $_POST['ruang_matkul'];
    $user_input = $_SESSION['username'];

    // Check if kelas_matkul already exists on the same day
    $check_kelas = mysqli_query($conn, "
        SELECT * FROM trx_matkul 
        WHERE kelas_matkul = '$kelas_matkul' AND  kode_matkul='$kode_matkul'
    ");

    if (mysqli_num_rows($check_kelas) > 0) {
        setFlash('Kelas sudah terdaftar!', 'error');
        echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
        exit;
    }

    // Proceed with insert
    $insert = mysqli_query($conn, "
        INSERT INTO trx_matkul (kode_matkul, nik, hari_matkul, kelas_matkul, ruang_matkul, user_input) 
        VALUES ('$kode_matkul', '$nik', '$hari_matkul', '$kelas_matkul', '$ruang_matkul', '$user_input')
    ");

    setFlash($insert ? 'Kelas berhasil ditambahkan!' : 'Gagal menambahkan kelas.', $insert ? 'success' : 'error');
    echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
    exit;
}




// Fetch dosen and matakuliah
$dosen = mysqli_query($conn, "SELECT nik, nama FROM dosen");
$matkul = mysqli_query($conn, "SELECT kode_matkul, nama_matkul FROM matakuliah");

ob_start();
?>

<form method="POST" action="/menu/krs/tambah_kelas.php" class="space-y-4">
    <!-- Matakuliah -->
    <div>
        <label for="kode_matkul" class="block mb-1 font-medium text-gray-700">Matakuliah</label>
        <select name="kode_matkul" id="kode_matkul" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="" disabled selected>-- Pilih Matakuliah --</option>
            <?php while ($m = mysqli_fetch_assoc($matkul)): ?>
                <option value="<?= $m['kode_matkul'] ?>"><?= $m['kode_matkul'] ?> - <?= $m['nama_matkul'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Dosen -->
    <div>
        <label for="nik" class="block mb-1 font-medium text-gray-700">Dosen</label>
        <select name="nik" id="nik" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="" disabled selected>-- Pilih Dosen --</option>
            <?php while ($d = mysqli_fetch_assoc($dosen)): ?>
                <option value="<?= $d['nik'] ?>"><?= $d['nama'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Hari -->
    <div>
        <label for="hari_matkul" class="block mb-1 font-medium text-gray-700">Hari</label>
        <select name="hari_matkul" id="hari_matkul" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
            <option value="Minggu">Minggu</option>
        </select>
    </div>

    <!-- Kelas -->
    <div>
        <label for="kelas_matkul" class="block mb-1 font-medium text-gray-700">Kelas</label>
        <input type="text" name="kelas_matkul" id="kelas_matkul" maxlength="3" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Ruangan -->
    <div>
        <label for="ruang_matkul" class="block mb-1 font-medium text-gray-700">Ruangan</label>
        <input type="text" name="ruang_matkul" id="ruang_matkul" maxlength="5" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Submit Button -->
    <div class="text-right">
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            Simpan
        </button>
    </div>
</form>



<?php
echo ob_get_clean();
?>
