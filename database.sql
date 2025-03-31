CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL,
    nama VARCHAR(100) NOT NULL
);

CREATE TABLE dosen (
    nik VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100),
    gelar VARCHAR(50),
    lulusan VARCHAR(100),
    telp VARCHAR(15),
    user_input VARCHAR(50),
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mahasiswa (
    nim VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100),
    tahun_masuk INT,
    alamat TEXT,
    telp VARCHAR(15),
    user_input VARCHAR(50),
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE matakuliah (
    kode_matkul VARCHAR(20) PRIMARY KEY,
    nama_matkul VARCHAR(100),
    sks INT,
    semester INT,
    user_input VARCHAR(50),
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE krs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_matkul VARCHAR(20),
    nik_dosen VARCHAR(20),
    nim_mahasiswa VARCHAR(20),
    hari_matkul VARCHAR(20),
    ruangan VARCHAR(50),
    user_input VARCHAR(50),
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kode_matkul) REFERENCES matakuliah(kode_matkul),
    FOREIGN KEY (nik_dosen) REFERENCES dosen(nik),
    FOREIGN KEY (nim_mahasiswa) REFERENCES mahasiswa(nim)
);

-- Insert 10 data dosen
INSERT INTO dosen (nik, nama, gelar, lulusan, telp, user_input) VALUES
('D001', 'Dr. Budi Santoso', 'Ph.D', 'ITB', '081234567890', 'admin'),
('D002', 'Prof. Andi Wijaya', 'M.Sc', 'UGM', '081298765432', 'admin'),
('D003', 'Dr. Sri Lestari', 'Ph.D', 'UI', '081211122233', 'admin'),
('D004', 'Dr. Rudi Hartono', 'M.T', 'ITS', '081244455566', 'admin'),
('D005', 'Prof. Dina Kurnia', 'M.Sc', 'UNPAD', '081255566677', 'admin'),
('D006', 'Dr. Eka Prasetya', 'Ph.D', 'UB', '081266677788', 'admin'),
('D007', 'Dr. Laila Rahmawati', 'M.T', 'UNDIP', '081277788899', 'admin'),
('D008', 'Dr. Tommy Gunawan', 'M.T', 'UIN', '081288899900', 'admin'),
('D009', 'Dr. Hasan Basri', 'Ph.D', 'UNS', '081299900011', 'admin'),
('D010', 'Prof. Rina Kusuma', 'M.Sc', 'USU', '081233344455', 'admin');

-- Insert 30 data mahasiswa
INSERT INTO mahasiswa (nim, nama, tahun_masuk, alamat, telp, user_input) VALUES
('M001', 'Ahmad Syarif', 2022, 'Jakarta', '081212345678', 'admin'),
('M002', 'Bunga Citra', 2021, 'Bandung', '081223456789', 'admin'),
('M003', 'Cahyo Wijaya', 2023, 'Surabaya', '081234567890', 'admin'),
('M004', 'Dewi Lestari', 2020, 'Yogyakarta', '081245678901', 'admin'),
('M005', 'Eko Prasetyo', 2022, 'Semarang', '081256789012', 'admin'),
('M006', 'Farah Azzahra', 2023, 'Malang', '081267890123', 'admin'),
('M007', 'Gunawan Saputra', 2021, 'Bekasi', '081278901234', 'admin'),
('M008', 'Herlina Kusuma', 2020, 'Depok', '081289012345', 'admin'),
('M009', 'Irfan Maulana', 2022, 'Bogor', '081290123456', 'admin'),
('M010', 'Joko Widodo', 2023, 'Tangerang', '081201234567', 'admin'),
('M011', 'Kurniawan Hadi', 2021, 'Medan', '081212345679', 'admin'),
('M012', 'Lisa Marlina', 2020, 'Palembang', '081223456780', 'admin'),
('M013', 'Muhammad Rizki', 2022, 'Makassar', '081234567891', 'admin'),
('M014', 'Nadia Safitri', 2023, 'Pekanbaru', '081245678902', 'admin'),
('M015', 'Oktaviani Dewi', 2021, 'Bali', '081256789013', 'admin'),
('M016', 'Putra Perdana', 2020, 'Pontianak', '081267890124', 'admin'),
('M017', 'Qisthi Rahayu', 2022, 'Manado', '081278901235', 'admin'),
('M018', 'Rahmat Hidayat', 2023, 'Jayapura', '081289012346', 'admin'),
('M019', 'Siti Aminah', 2021, 'Batam', '081290123457', 'admin'),
('M020', 'Teguh Setiawan', 2020, 'Balikpapan', '081201234568', 'admin'),
('M021', 'Umar Abdul', 2022, 'Banjarmasin', '081212345670', 'admin'),
('M022', 'Vania Febriani', 2023, 'Mataram', '081223456781', 'admin'),
('M023', 'Wahyudi Saputra', 2021, 'Samarinda', '081234567892', 'admin'),
('M024', 'Xavier Ardi', 2020, 'Kupang', '081245678903', 'admin'),
('M025', 'Yusuf Maulana', 2022, 'Ambon', '081256789014', 'admin'),
('M026', 'Zahra Nuraini', 2023, 'Palangkaraya', '081267890125', 'admin'),
('M027', 'Asep Juhari', 2021, 'Gorontalo', '081278901236', 'admin'),
('M028', 'Bima Sakti', 2020, 'Ternate', '081289012347', 'admin'),
('M029', 'Citra Wulandari', 2022, 'Sumbawa', '081290123458', 'admin'),
('M030', 'Dian Anggraini', 2023, 'Lombok', '081201234569', 'admin');

-- Insert 10 data matakuliah
INSERT INTO matakuliah (kode_matkul, nama_matkul, sks, semester, user_input) VALUES
('MK001', 'Pemrograman Web', 3, 4, 'admin'),
('MK002', 'Algoritma dan Struktur Data', 3, 2, 'admin'),
('MK003', 'Jaringan Komputer', 3, 5, 'admin'),
('MK004', 'Kecerdasan Buatan', 3, 6, 'admin'),
('MK005', 'Keamanan Informasi', 3, 7, 'admin'),
('MK006', 'Sistem Operasi', 3, 3, 'admin'),
('MK007', 'Analisis dan Perancangan Sistem', 3, 5, 'admin'),
('MK008', 'Manajemen Basis Data', 3, 4, 'admin'),
('MK009', 'Interaksi Manusia dan Komputer', 3, 4, 'admin'),
('MK010', 'Pemrograman Mobile', 3, 6, 'admin');

-- Insert 30 data KRS
INSERT INTO krs (kode_matkul, nik_dosen, nim_mahasiswa, hari_matkul, ruangan, user_input) VALUES
('MK001', 'D001', 'M001', 'Senin', 'R101', 'admin'),
('MK002', 'D002', 'M002', 'Selasa', 'R102', 'admin'),
('MK003', 'D003', 'M003', 'Rabu', 'R103', 'admin'),
('MK004', 'D004', 'M004', 'Kamis', 'R104', 'admin'),
('MK005', 'D005', 'M005', 'Jumat', 'R105', 'admin'),
('MK006', 'D006', 'M006', 'Senin', 'R106', 'admin'),
('MK007', 'D007', 'M007', 'Selasa', 'R107', 'admin'),
('MK008', 'D008', 'M008', 'Rabu', 'R108', 'admin'),
('MK009', 'D009', 'M009', 'Kamis', 'R109', 'admin'),
('MK010', 'D010', 'M010', 'Jumat', 'R110', 'admin'),
('MK001', 'D001', 'M011', 'Senin', 'R101', 'admin'),
('MK002', 'D002', 'M012', 'Selasa', 'R102', 'admin'),
('MK003', 'D003', 'M013', 'Rabu', 'R103', 'admin'),
('MK004', 'D004', 'M014', 'Kamis', 'R104', 'admin'),
('MK005', 'D005', 'M015', 'Jumat', 'R105', 'admin'),
('MK006', 'D006', 'M016', 'Senin', 'R106', 'admin'),
('MK007', 'D007', 'M017', 'Selasa', 'R107', 'admin'),
('MK008', 'D008', 'M018', 'Rabu', 'R108', 'admin'),
('MK009', 'D009', 'M019', 'Kamis', 'R109', 'admin'),
('MK010', 'D010', 'M020', 'Jumat', 'R110', 'admin');

-- Tambahkan 10 data KRS lainnya dengan kombinasi acak.

INSERT INTO users (id, username, password, role, nama) VALUES
(1, 'admin', '$2y$10$gg89S/9VgY7H1t03ntGWQO/S0AvAf6wxNO/gQ/8lGptaJGV9fZffu', 'admin', 'Admin User'),
(2, 'budi', '$2y$10$gg89S/9VgY7H1t03ntGWQO/S0AvAf6wxNO/gQ/8lGptaJGV9fZffu', 'mahasiswa', 'Budi Santoso'),
(3, 'gonda', '$$2y$10$gg89S/9VgY7H1t03ntGWQO/S0AvAf6wxNO/gQ/8lGptaJGV9fZffu', 'mahasiswa', 'Gonda'),
(4, 'dosen1', '$$2y$10$gg89S/9VgY7H1t03ntGWQO/S0AvAf6wxNO/gQ/8lGptaJGV9fZffu', 'dosen', 'Dr. Iwan Setiawan'),
(5, 'staff', '$2y$10$gg89S/9VgY7H1t03ntGWQO/S0AvAf6wxNO/gQ/8lGptaJGV9fZffu', 'staff', 'Siti Rahma');

