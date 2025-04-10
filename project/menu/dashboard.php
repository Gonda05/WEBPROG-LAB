<?php
$role = $_SESSION['role'];
$username = $_SESSION['username']; // assuming this stores the current user info
include "../config.php";

function getTotalCount($conn, $tableName) {
    $query = "SELECT COUNT(*) as total FROM $tableName";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

if ($role === 'admin') {
    $totalDosen = getTotalCount($conn, 'dosen');
    $totalMahasiswa = getTotalCount($conn, 'mahasiswa');
    $totalMatakuliah = getTotalCount($conn, 'matakuliah');
}
?>
<div class="flex-grow h-full w-full">
    <h1 class="text-2xl mb-4"><b>Dashboard</b></h1>

    <div class="statistics flex-grow h-[90%] w-full relative bg-[#FAFAFA] shadow-xl rounded-lg p-4 overflow-hidden border-2 border-stone-300">
        <div class="p-2">
            <?php if ($role === 'admin') : ?>
            <div class="jumlah flex flex-row gap-2 mb-4">
                <div class="flex-grow text-white bg-[#D58E1D] p-5 rounded-lg border-2 border-[#60400F]">
                    <p class="font-medium text-lg">Jumlah Dosen</p>
                    <div class="font-bold text-5xl"><?= $totalDosen?></div>
                </div>
                <div class="flex-grow text-white bg-[#D58E1D] p-5 rounded-lg border-2 border-[#60400F]">
                    <p class="font-medium text-lg">Jumlah Mahasiswa</p>
                    <div class="font-bold text-5xl"><?= $totalMahasiswa?></div>
                </div>
                <div class="flex-grow text-white bg-[#D58E1D] p-5 rounded-lg border-2 border-[#60400F]">
                    <p class="font-medium text-lg">Jumlah Mata Kuliah</p>
                    <div class="font-bold text-5xl"><?= $totalMatakuliah?></div>
                </div>
            </div>
            <?php endif; ?>

            <div class="days flex gap-4 overflow-x-auto whitespace-nowrap px-1">
                <?php
                $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                $warna = array_fill(0, 7, 'bg-gray-200');

                foreach ($hariList as $index => $hari) {
                    echo '<div class="min-w-[300px] max-w-[300px] p-4 rounded-xl shadow-md border border-gray-300 '.$warna[$index].'">';
                    echo "<h2 class='text-xl font-bold mb-2'>$hari</h2>";

                    // Schedule query based on role
                    if ($role === 'admin') {
                        $query = "
                            SELECT tm.kelas_matkul, mk.nama_matkul, ds.nama AS nama_dosen, tm.ruang_matkul
                            FROM trx_matkul tm
                            JOIN matakuliah mk ON tm.kode_matkul = mk.kode_matkul
                            JOIN dosen ds ON tm.nik = ds.nik
                            WHERE tm.hari_matkul = '$hari'
                            ORDER BY tm.kelas_matkul ASC
                        ";
                    } elseif ($role === 'dosen') {
                        $query = "
                            SELECT tm.kelas_matkul, mk.nama_matkul, ds.nama AS nama_dosen, tm.ruang_matkul
                            FROM trx_matkul tm
                            JOIN matakuliah mk ON tm.kode_matkul = mk.kode_matkul
                            JOIN dosen ds ON tm.nik = ds.nik
                            WHERE tm.hari_matkul = '$hari' AND tm.nik = (
                                SELECT nik FROM users WHERE username = '$username'
                            )
                            ORDER BY tm.kelas_matkul ASC
                        ";
                    } elseif ($role === 'mahasiswa') {
                        $query = "
                            SELECT tm.kelas_matkul, mk.nama_matkul, ds.nama AS nama_dosen, tm.ruang_matkul
                            FROM trx_krs krs
                            JOIN trx_matkul tm ON krs.id_trx_matkul = tm.id_trx_matkul
                            JOIN matakuliah mk ON tm.kode_matkul = mk.kode_matkul
                            JOIN dosen ds ON tm.nik = ds.nik
                            WHERE tm.hari_matkul = '$hari' AND krs.nim = (
                                SELECT nim FROM users WHERE username = '$username'
                            )
                            ORDER BY tm.kelas_matkul ASC
                        ";
                    }

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<div class='h-[210px] overflow-y-auto overflow-x-hidden'>";
                        echo "<ul class='space-y-2 w-full'>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li class='bg-white p-3 rounded-lg border border-gray-300 shadow-sm w-full'>";
                            echo "<div class='font-semibold text-wrap text-lg'>{$row['nama_matkul']} <span class='text-sm text-wrap text-gray-600'>({$row['kelas_matkul']})</span></div>";
                            echo "<div class='text-sm text-gray-700'>Dosen: {$row['nama_dosen']}</div>";
                            echo "<div class='text-sm text-gray-500'>Ruang: {$row['ruang_matkul']}</div>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {
                        echo "<p class='text-gray-600 italic'>Tidak ada kelas.</p>";
                    }

                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
