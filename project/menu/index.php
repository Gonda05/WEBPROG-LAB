<?php
include_once("../auth.php");

include '../components/alert.php';
displayFlash();

// Define an array of sidebar items
$username = $_SESSION['username'];
$role = $_SESSION['role'];
error_log($_SESSION['username']);

$sidebarItems = [
    ["name" => "Dashboard", "icon" => "../asset/Home.png", "link" => "?page=dashboard", "roles" => ["admin"]],
    ["name" => "Dosen", "icon" => "../asset/Users.png", "link" => "?page=dosen", "roles" => ["admin"]],
    ["name" => "Mahasiswa", "icon" => "../asset/Book.png", "link" => "?page=mahasiswa", "roles" => ["admin"]],
    ["name" => "Mata Kuliah", "icon" => "../asset/Book open.png", "link" => "?page=matakuliah", "roles" => ["admin"]],
    ["name" => "KRS", "icon" => "../asset/Bookmark.png", "link" => "?page=krs", "roles" => ["admin"]],
    // ["name" => "Users", "icon" => "../asset/User plus.png", "link" => "?page=users", "roles" => ["admin"]],
    ["name" => "Laporan Jadwal", "icon" => "../asset/Book open.png", "link" => "?page=users", "roles" => ["dosen"]],
    ["name" => "Laporan Jadwal", "icon" => "../asset/Book open.png", "link" => "?page=users", "roles" => ["mahasiswa"]],
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Main Menu</title>
</head>
<body class="h-dvh w-screen overflow-hidden bg-[#F1EEEE]">
    <div class="header h-16 flex flex-row w-full items-center justify-between px-4 py-2 bg-[#FAFAFA] border-b-2 border-b-[#6B6765]/50">
        <img class="h-auto w-auto cursor-pointer" src="../asset/myUMN!.png" onclick="window.location.href='/menu/index.php'"/>
        <div class="relative flex flex-row items-center space-x-4"> 
            <div class="flex flex-row items-center space-x-2 cursor-pointer" onclick="toggleDropdown()" id="chevron-trigger">
                <p class="text-nowrap"><?=$username?></p>
                <img class="h-4 w-4" src="../asset/Chevron down.png" />
            </div>
            <div class="relative w-12 h-12">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-blue-900 rounded-full p-[3px]">
                    <img class="w-full h-full rounded-full object-cover" src="../asset/LeonTest.png" />
                </div>
            </div>
            
            <div id="dropdown-menu" class="hidden absolute z-50 top-16 right-0 bg-white shadow-lg rounded-md py-2 w-40 border border-gray-200">
                <?php if ($role === 'admin'): ?>
                    <a href="/menu/password.php" class="flex flex-row gap-4 px-4 py-2 text-base font-semibold hover:bg-gray-100">
                        <img class="w-5 h-5 object-contain" src="../asset/Settings.png" />
                        Settings
                    </a>
                <?php endif; ?>
                
                <a href="/login/logout.php" class="flex flex-row gap-4 px-4 py-2 text-base font-semibold hover:bg-gray-100">
                    <img class="w-5 h-5 object-contain" src="../asset/Log out.png" />
                    Logout
                </a>
            </div>

        </div>
    </div>
    

    <div class="flex" style="height: calc(100vh - 4rem);">
        <!-- Sidebar -->
        <div id="default-sidebar" class="w-64 flex-shrink-0 bg-gray-50">
            <div class="h-100 px-3 py-4 overflow-y-auto bg-gray-50 light:bg-[#FAFAFA]">
                <ul class="space-y-2 font-medium">
                <?php foreach ($sidebarItems as $item): ?>
                    <?php if (in_array($role, $item['roles'])): ?>
                        <li>
                            <a href="<?= htmlspecialchars($item['link']); ?>" 
                            class="flex items-center p-2 text-[#0A175F] transition duration-75 rounded-lg hover:bg-[#D58E1D] hover:text-white group">
                                <img class="w-6 h-6 mr-3 transition duration-75 group-hover:invert group-hover:brightness-0" 
                                    src="<?= htmlspecialchars($item['icon']); ?>" 
                                    alt="<?= htmlspecialchars($item['name']); ?>">
                                <span class="text-[#0A175F] transition duration-75 group-hover:text-white"><?= htmlspecialchars($item['name']); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>



                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow h-full w-full position-relative bg-[#F1EEEE] p-4 overflow-y-scroll">
            <?php
                $page = $_GET['page'] ?? 'dashboard'; // default to 'dashboard'
                
                // Define allowed pages and their include paths
                $allowedPages = [
                    'dashboard' => 'dashboard.php',
                    'dosen' => './dosen/index.php',
                    'mahasiswa' => './mahasiswa/index.php',
                    'matakuliah' => './matakuliah/index.php',
                    'krs' => './krs/index.php'
                ];

                if (array_key_exists($page, $allowedPages)) {
                    include $allowedPages[$page];
                } else {
                    echo "<p class='text-red-500'>Page not found.</p>";
                }
            ?>
        </div>

    </div>
    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }
    
        // Optional: Close dropdown if clicked outside
        document.addEventListener('click', function (event) {
            const trigger = document.getElementById('chevron-trigger');
            const menu = document.getElementById('dropdown-menu');
    
            if (!trigger.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>