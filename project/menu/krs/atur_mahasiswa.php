<?php
ob_start();
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

$id_trx_matkul = $_GET['id_trx_matkul'] ?? null;

if (!$id_trx_matkul) {
    setFlash('ID kelas tidak ditemukan.', 'error');
    header('Location: /menu/trx_matkul?page=krs');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = $_SESSION['username'] ?? 'unknown';
    $tanggal_input = date('Y-m-d');

    // Adding mahasiswa
    if (isset($_POST['nim'])) {
        $nim = $_POST['nim'];

        if ($nim) {
            $insertQuery = "INSERT INTO trx_krs (id_trx_matkul, nim, user_input, tanggal_input)
                            VALUES ('$id_trx_matkul', '$nim', '$user_input', '$tanggal_input')";
            if (mysqli_query($conn, $insertQuery)) {
                setFlash('Mahasiswa berhasil ditambahkan.', 'success');
                header('Location: /menu/trx_matkul?page=krs');
                exit;
            } else {
                setFlash('Gagal menambahkan mahasiswa: ' . mysqli_error($conn), 'error');
            }
        }
    }

    // Deleting mahasiswa
    if (isset($_POST['delete_nim'])) {
        $delete_nim = $_POST['delete_nim'];

        if ($delete_nim) {
            $deleteQuery = "DELETE FROM trx_krs WHERE id_trx_matkul = '$id_trx_matkul' AND nim = '$delete_nim'";
            if (mysqli_query($conn, $deleteQuery)) {
                setFlash('Mahasiswa berhasil dihapus.', 'success');
                header('Location: /menu/trx_matkul?page=krs');
                exit;
            } else {
                setFlash('Gagal menghapus mahasiswa: ' . mysqli_error($conn), 'error');
            }
        }
    }
}

// Fetch enrolled students into an array
$enrolledQuery = "SELECT mahasiswa.nim, mahasiswa.nama 
                  FROM trx_krs 
                  JOIN mahasiswa ON trx_krs.nim = mahasiswa.nim 
                  WHERE trx_krs.id_trx_matkul = '$id_trx_matkul'
                  ORDER BY mahasiswa.nim ASC";
$enrolledResult = mysqli_query($conn, $enrolledQuery);

$enrolledMahasiswa = [];
if ($enrolledResult) {
    while ($row = mysqli_fetch_assoc($enrolledResult)) {
        $enrolledMahasiswa[] = $row;
    }
}


// Fetch mahasiswa not yet enrolled in this course (same kode_matkul)
$allMahasiswaQuery = "
SELECT m.nim, m.nama 
FROM mahasiswa m 
WHERE m.nim NOT IN (
    SELECT krs.nim 
    FROM trx_krs krs
    JOIN trx_matkul tm2 ON krs.id_trx_matkul = tm2.id_trx_matkul
    WHERE tm2.kode_matkul = (
        SELECT kode_matkul 
        FROM trx_matkul 
        WHERE id_trx_matkul = '$id_trx_matkul'
    )
)";
$allMahasiswaResult = mysqli_query($conn, $allMahasiswaQuery);
?>

<body class="p-6">

<!-- Form to enroll mahasiswa -->
<form method="POST" class="mb-4" action="/menu/krs/atur_mahasiswa.php?id_trx_matkul=<?= urlencode($id_trx_matkul) ?>">
  <label for="nim" class="block mb-2 font-medium">Pilih Mahasiswa</label>
  <select name="nim" id="nim" class="w-full p-2 border border-gray-300 rounded mb-2" required>
    <option value="">-- Pilih Mahasiswa --</option>
    <?php while ($m = mysqli_fetch_assoc($allMahasiswaResult)): ?>
      <option value="<?= htmlspecialchars($m['nim']) ?>"><?= htmlspecialchars($m['nim']) ?> - <?= htmlspecialchars($m['nama']) ?></option>
    <?php endwhile; ?>
  </select>
  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</button>
</form>

<!-- Form to delete mahasiswa -->
<form method="POST" class="mb-4" action="/menu/krs/atur_mahasiswa.php?id_trx_matkul=<?= urlencode($id_trx_matkul) ?>">
  <label for="delete_nim" class="block mb-2 font-medium">Hapus Mahasiswa</label>
  <select name="delete_nim" id="delete_nim" class="w-full p-2 border border-red-300 rounded mb-2" required>
    <option value="">-- Pilih Mahasiswa untuk Dihapus --</option>
    <?php foreach ($enrolledMahasiswa as $row): ?>
      <option value="<?= htmlspecialchars($row['nim']) ?>">
        <?= htmlspecialchars($row['nim']) ?> - <?= htmlspecialchars($row['nama']) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
</form>


<!-- List of enrolled mahasiswa -->
<h3 class="text-lg font-semibold mb-2">Mahasiswa yang Terdaftar:</h3>
<div class="overflow-y-auto max-h-[210px] border border-gray-300 rounded">
  <table class="w-full table-auto border-collapse">
    <thead class="sticky top-0 bg-gray-100">
      <tr>
        <th class="border p-2">NIM</th>
        <th class="border p-2">Nama</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($enrolledMahasiswa as $row): ?>
        <tr>
          <td class="border p-2"><?= htmlspecialchars($row['nim']) ?></td>
          <td class="border p-2"><?= htmlspecialchars($row['nama']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>

<?php
echo ob_get_clean();
?>
