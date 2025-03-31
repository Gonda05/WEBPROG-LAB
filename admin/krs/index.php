<?php
include '../config.php';

// Ambil data KRS dari database
$query = "SELECT krs.id, matakuliah.nama_matkul, dosen.nama AS nama_dosen, mahasiswa.nama AS nama_mahasiswa, krs.hari_matkul, krs.ruangan 
          FROM krs 
          JOIN matakuliah ON krs.kode_matkul = matakuliah.kode_matkul
          JOIN dosen ON krs.nik_dosen = dosen.nik
          JOIN mahasiswa ON krs.nim_mahasiswa = mahasiswa.nim";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data KRS</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Data KRS</h2>
    <a href="tambah.php">Tambah KRS</a>
    <table border="1">
        <tr>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Mahasiswa</th>
            <th>Hari</th>
            <th>Ruangan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['nama_matkul']; ?></td>
            <td><?= $row['nama_dosen']; ?></td>
            <td><?= $row['nama_mahasiswa']; ?></td>
            <td><?= $row['hari_matkul']; ?></td>
            <td><?= $row['ruangan']; ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>

</body>
</html>
