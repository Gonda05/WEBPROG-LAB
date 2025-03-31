<?php
include '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM dosen";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #E5E7EB; 
            text-align: center; 
        }
        .container { 
            width: 80%; 
            margin: auto; 
            padding: 20px; 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 { color: #1E3A8A; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #374151; 
            padding: 10px; 
            text-align: left; 
        }
        th { background-color: #F59E0B; color: white; }
        .btn {
            background: #1E3A8A; 
            color: white; 
            padding: 8px 12px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block;
            margin: 5px;
        }
        .btn:hover { background: #374151; }
        .btn-danger { background: #DC2626; } 
        .btn-danger:hover { background: #B91C1C; }
        .back-btn { 
            background: #F59E0B; 
            color: white; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            margin-top: 20px; 
        }
        .back-btn:hover { background: #D97706; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Dosen</h2>
        <a href="tambah.php" class="btn">Tambah Dosen</a>
        <table>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gelar</th>
                <th>Lulusan</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['nik']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['gelar']); ?></td>
                    <td><?= htmlspecialchars($row['lulusan']); ?></td>
                    <td><?= htmlspecialchars($row['telp']); ?></td>
                    <td>
                        <a href="edit.php?nik=<?= urlencode($row['nik']); ?>" class="btn">Edit</a>
                        <a href="hapus.php?nik=<?= urlencode($row['nik']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="../login/menu_utama.php" class="back-btn">Kembali ke Menu Utama</a>
    </div>
</body>
</html>
