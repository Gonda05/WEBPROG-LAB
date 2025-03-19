<?php
$krs = $conn->query("SELECT krs.id, mata_kuliah.nama_matkul, mata_kuliah.kode_matkul 
                     FROM krs 
                     JOIN mata_kuliah ON krs.mk_id = mata_kuliah.id 
                     WHERE krs.mahasiswa_id='{$_SESSION['user_id']}'");

echo "<h3>Daftar Mata Kuliah</h3>";
while ($row = $krs->fetch_assoc()) {
    echo "<p>{$row['kode_matkul']} - {$row['nama_matkul']}</p>";
}
?>
