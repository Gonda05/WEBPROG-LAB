<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$menus = [
    'admin' => [
        'Master Dosen' => '../dosen/index.php',
        'Master Mahasiswa' => '../mahasiswa/index.php',
        'Master Mata Kuliah' => '../matakuliah/index.php',
        'Transaksi KRS' => '../krs/index.php',
        'Laporan' => '../laporan/index.php',
        'Buat users baru' => '../login/users.php',
    ],
    'dosen' => [
        'Jadwal Mengajar' => '../laporan/dosen.php'
    ],
    'mahasiswa' => [
        'Jadwal Kuliah' => '../laporan/mahasiswa.php'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E5E7EB;
            color: #374151;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h1 {
            color: #1E3A8A;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #F59E0B;
            font-weight: bold;
        }
        a:hover {
            color: #1E3A8A;
        }
        .logout {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1E3A8A;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #F59E0B;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <h3>Menu:</h3>
        <ul>
            <?php
            if (isset($menus[$role])) {
                foreach ($menus[$role] as $menu => $link) {
                    echo "<li><a href='" . htmlspecialchars($link) . "'>" . htmlspecialchars($menu) . "</a></li>";
                }
            } else {
                echo "<li>Menu tidak tersedia</li>";
            }
            ?>
        </ul>
        <form action="logout.php" method="post">
            <button type="submit" class="logout">Sign Out</button>
        </form>
    </div>
</body>
</html>
