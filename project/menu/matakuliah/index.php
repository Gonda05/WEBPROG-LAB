<?php
include '../config.php';
include '../components/table.php';
include '../components/modal.php';

$sortField = $_GET['sort'] ?? 'kode_matkul';
$sortDir = strtolower($_GET['dir'] ?? 'asc');
$sortDir = ($sortDir === 'desc') ? 'DESC' : 'ASC';

$searchField = $_GET['field'] ?? '';
$searchKeyword = $_GET['keyword'] ?? '';

// Whitelist fields
$allowedFields = ['kode_matkul', 'nama_matkul', 'sks', 'semester', 'user_input', 'tanggal_input'];
$whereClause = '';

if ($searchField && $searchKeyword && in_array($searchField, $allowedFields)) {
    $safeKeyword = mysqli_real_escape_string($conn, $searchKeyword);
    $whereClause = "WHERE $searchField LIKE '%$safeKeyword%'";
}

if (!in_array($sortField, $allowedFields)) {
    $sortField = 'id';
}

$query = "SELECT * FROM matakuliah $whereClause ORDER BY $sortField $sortDir";
$result = mysqli_query($conn, $query);
?>

<!-- Trigger buttons -->
<h1 class="text-3xl font-semibold mb-2">Data Mata Kuliah</h1>
<div class="flex flex-wrap items-center justify-between gap-2">

<form class="flex-grow min-w-[200px]" method="GET" action="">
        <!-- Preserve other GET params -->
        <?php foreach ($_GET as $key => $value): ?>
            <?php if (!in_array($key, ['field', 'keyword'])): ?>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="flex w-full">
            <!-- Select Dropdown -->
            <select
                name="field"
                class="shrink-0 z-10 inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
            >
                <option value="">Pilih</option>
                <?php foreach ($allowedFields as $field): ?>
                    <option value="<?= $field ?>" <?= ($searchField === $field) ? 'selected' : '' ?>>
                        <?= ucfirst($field) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Input and Button -->
            <div class="relative flex-grow flex flex-row">
                <input
                    type="text"
                    name="keyword"
                    value="<?= htmlspecialchars($searchKeyword) ?>"
                    class="block p-2 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 pr-10"
                    placeholder="Cari data matkul..."
                    required
                />

                <?php
                    // Keep only the 'page' param, if exists
                    $query = [];
                    if (isset($_GET['page'])) {
                        $query['page'] = $_GET['page'];
                    }
                    $clearUrl = '?' . http_build_query($query);
                ?>

                <!-- Clear Button (X) -->
                <a href="<?= $clearUrl ?>" class="absolute top-1/2 -translate-y-1/2 right-10 text-gray-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Clear search</span>
                </a>

                <!-- Search Button -->
                <button
                    type="submit"
                    class="relative top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                >
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>

        </div>
    </form>

    <button
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        onclick="openModal({ title: 'Tambah Mata Kuliah', url: '/menu/matakuliah/tambah.php' })"
    >
        Tambah Mata Kuliah
    </button>
</div>

<?php
render_table($result, [
    'Edit' => 'javascript:void(0)" onclick="openModal({ title: \'Edit Mata Kuliah\', url: \'/menu/matakuliah/edit.php?kode_matkul={kode_matkul}\' })',
    'Hapus' => '/menu/matakuliah/hapus.php?kode_matkul={kode_matkul}'
]);
?>
