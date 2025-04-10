<?php
include '../config.php';
include '../components/table.php';
include '../components/modal.php';

$sortField = $_GET['sort'] ?? 'id_trx_matkul';
$sortDir = strtolower($_GET['dir'] ?? 'asc');
$sortDir = ($sortDir === 'desc') ? 'DESC' : 'ASC';

$searchField = $_GET['field'] ?? '';
$searchKeyword = $_GET['keyword'] ?? '';
$allowedFields = ['kelas_matkul', 'hari_matkul', 'jam_matkul', 'ruang_matkul', 'kode_matkul', 'nik', 'user_input', 'tanggal_input'];
$whereClause = '';

if ($searchField && $searchKeyword && in_array($searchField, $allowedFields)) {
    $safeKeyword = mysqli_real_escape_string($conn, $searchKeyword);
    $whereClause = "WHERE $searchField LIKE '%$safeKeyword%'";
}

if (!in_array($sortField, $allowedFields)) {
    $sortField = 'id_trx_matkul';
}

$query = "SELECT trx_matkul.id_trx_matkul as ID,matakuliah.nama_matkul,trx_matkul.hari_matkul, trx_matkul.kelas_matkul, dosen.nama AS nama_dosen, matakuliah.sks,trx_matkul.user_input, trx_matkul.tanggal_input 
          FROM trx_matkul
          JOIN dosen ON trx_matkul.nik = dosen.nik
          JOIN matakuliah ON trx_matkul.kode_matkul = matakuliah.kode_matkul
          $whereClause
          ORDER BY $sortField $sortDir";

$result = mysqli_query($conn, $query);
?>

<h1 class="text-3xl font-semibold mb-2">Panel KRS</h1>
<div class="flex flex-wrap items-center justify-between gap-2">
  <form class="flex-grow min-w-[200px]" method="GET" action="">
    <?php foreach ($_GET as $key => $value): ?>
      <?php if (!in_array($key, ['field', 'keyword'])): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
      <?php endif; ?>
    <?php endforeach; ?>

    <div class="flex w-full">
      <select name="field" class="shrink-0 z-10 inline-flex items-center py-2 px-4 text-sm bg-gray-100 border border-gray-300 rounded-s-lg">
        <option value="">Pilih</option>
        <?php foreach ($allowedFields as $field): ?>
          <option value="<?= $field ?>" <?= ($searchField === $field) ? 'selected' : '' ?>><?= ucfirst($field) ?></option>
        <?php endforeach; ?>
      </select>

      <div class="relative flex-grow flex flex-row">
        <input type="text" name="keyword" value="<?= htmlspecialchars($searchKeyword) ?>" class="block p-2 w-full text-sm border border-gray-300 pr-10" placeholder="Cari jadwal..." required />
        <a href="?" class="absolute top-1/2 -translate-y-1/2 right-10 text-gray-400 hover:text-red-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </a>
        <button type="submit" class="relative top-0 end-0 p-2.5 text-sm text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </button>
      </div>
    </div>
  </form>

  <button
    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5"
    onclick="openModal({ title: 'Tambah Kelas', url: '/menu/krs/tambah_kelas.php' })">
    Tambah Kelas
  </button>
</div>

<?php
render_table($result, [
    'Enroll' => "javascript:void(0);\" onclick=\"openModal({ title: 'Atur Mahasiswa', url: '/menu/krs/atur_mahasiswa.php?id_trx_matkul={ID}' })",
    'Edit' => 'javascript:void(0)" onclick="openModal({ title: \'Edit Kelas\', url: \'/menu/krs/edit_kelas.php?id_trx_matkul={ID}\' })',
    'Hapus' => '/menu/krs/hapus_kelas.php?id_trx_matkul={ID}'
]);
?>
