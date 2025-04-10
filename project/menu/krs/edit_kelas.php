<?php
ob_start();
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

$id = $_POST['id_trx_matkul'] ?? $_GET['id_trx_matkul'] ?? null;
$isEdit = $id !== null;

// Fetch dosen and matakuliah
$dosen = mysqli_query($conn, "SELECT nik, nama FROM dosen");
$matkul = mysqli_query($conn, "SELECT kode_matkul, nama_matkul FROM matakuliah");

// Fetch existing class data if in edit mode
$data = null;
if ($isEdit && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $result = mysqli_query($conn, "SELECT * FROM trx_matkul WHERE id_trx_matkul = '$id'");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        setFlash('Data tidak ditemukan!', 'error');
        echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_matkul = $_POST['kode_matkul'];
    $nik = $_POST['nik'];
    $hari_matkul = $_POST['hari_matkul'];
    $kelas_matkul = $_POST['kelas_matkul'];
    $ruang_matkul = $_POST['ruang_matkul'];
    $user_input = $_SESSION['username'];

    // Check uniqueness of kelas_matkul
    $check_query = "
        SELECT * FROM trx_matkul 
        WHERE kelas_matkul = '$kelas_matkul'
        " . ($isEdit ? "AND id_trx_matkul != '$id'" : "") . "
    ";
    $check_kelas = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_kelas) > 0) {
        setFlash('Kelas sudah terdaftar!', 'error');
        echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
        exit;
    }

    // Perform update or insert
    if ($isEdit) {
        $query = "
            UPDATE trx_matkul SET 
                kode_matkul = '$kode_matkul', 
                nik = '$nik',
                hari_matkul = '$hari_matkul',
                kelas_matkul = '$kelas_matkul',
                ruang_matkul = '$ruang_matkul',
                user_input = '$user_input'
            WHERE id_trx_matkul = '$id'
        ";
        $result = mysqli_query($conn, $query);
        setFlash($result ? 'Kelas berhasil diperbarui!' : 'Gagal memperbarui kelas.', $result ? 'success' : 'error');
    } else {
        $query = "
            INSERT INTO trx_matkul (kode_matkul, nik, hari_matkul, kelas_matkul, ruang_matkul, user_input) 
            VALUES ('$kode_matkul', '$nik', '$hari_matkul', '$kelas_matkul', '$ruang_matkul', '$user_input')
        ";
        $result = mysqli_query($conn, $query);
        setFlash($result ? 'Kelas berhasil ditambahkan!' : 'Gagal menambahkan kelas.', $result ? 'success' : 'error');
    }

    echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
    exit;
}

ob_start();
?>

<form method="POST" action="/menu/krs/edit_kelas.php" class="space-y-4">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id_trx_matkul" value="<?= $id ?>">
    <?php endif; ?>

    <!-- Matakuliah -->
    <div>
        <label for="kode_matkul" class="block mb-1 font-medium text-gray-700">Matakuliah</label>
        <select name="kode_matkul" id="kode_matkul" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="" disabled <?= !$data ? 'selected' : '' ?>>-- Pilih Matakuliah --</option>
            <?php mysqli_data_seek($matkul, 0); while ($m = mysqli_fetch_assoc($matkul)): ?>
                <option value="<?= $m['kode_matkul'] ?>" <?= $data && $data['kode_matkul'] === $m['kode_matkul'] ? 'selected' : '' ?>>
                    <?= $m['kode_matkul'] ?> - <?= $m['nama_matkul'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Dosen -->
    <div>
        <label for="nik" class="block mb-1 font-medium text-gray-700">Dosen</label>
        <select name="nik" id="nik" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="" disabled <?= !$data ? 'selected' : '' ?>>-- Pilih Dosen --</option>
            <?php mysqli_data_seek($dosen, 0); while ($d = mysqli_fetch_assoc($dosen)): ?>
                <option value="<?= $d['nik'] ?>" <?= $data && $data['nik'] === $d['nik'] ? 'selected' : '' ?>>
                    <?= $d['nama'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Hari -->
    <div>
        <label for="hari_matkul" class="block mb-1 font-medium text-gray-700">Hari</label>
        <select name="hari_matkul" id="hari_matkul" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <?php 
            $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
            foreach ($days as $day):
            ?>
                <option value="<?= $day ?>" <?= $data && $data['hari_matkul'] === $day ? 'selected' : '' ?>><?= $day ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Kelas -->
    <div>
        <label for="kelas_matkul" class="block mb-1 font-medium text-gray-700">Kelas</label>
        <input type="text" name="kelas_matkul" id="kelas_matkul" maxlength="3" required
            value="<?= $data['kelas_matkul'] ?? '' ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Ruangan -->
    <div>
        <label for="ruang_matkul" class="block mb-1 font-medium text-gray-700">Ruangan</label>
        <input type="text" name="ruang_matkul" id="ruang_matkul" maxlength="5" required
            value="<?= $data['ruang_matkul'] ?? '' ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Submit Button -->
    <div class="text-right">
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            <?= $isEdit ? 'Perbarui' : 'Simpan' ?>
        </button>
    </div>
</form>

<?php
echo ob_get_clean();
?>
