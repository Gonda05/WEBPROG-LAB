-- Hapus database lama jika ada
DROP DATABASE IF EXISTS krs_system;

-- Buat database baru
CREATE DATABASE krs_system;
USE krs_system;

-- Buat tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL
);

-- Buat tabel Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Buat tabel Dosen
CREATE TABLE dosen (
    nik VARCHAR(20) PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    gelar VARCHAR(50) NOT NULL,
    lulusan VARCHAR(100) NOT NULL,
    telp VARCHAR(15) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Buat tabel Mahasiswa
CREATE TABLE mahasiswa (
    nim VARCHAR(20) PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tahun_masuk YEAR NOT NULL,
    alamat TEXT NOT NULL,
    telp VARCHAR(15) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Buat tabel Mata Kuliah
CREATE TABLE mata_kuliah (
    kode_matkul VARCHAR(10) PRIMARY KEY,
    nama_matkul VARCHAR(100) NOT NULL,
    sks INT NOT NULL,
    semester INT NOT NULL
);

-- Buat tabel KRS
CREATE TABLE krs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_matkul VARCHAR(10) NOT NULL,
    nik_dosen VARCHAR(20) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu') NOT NULL,
    ruang VARCHAR(10) NOT NULL,
    FOREIGN KEY (kode_matkul) REFERENCES mata_kuliah(kode_matkul) ON DELETE CASCADE,
    FOREIGN KEY (nik_dosen) REFERENCES dosen(nik) ON DELETE CASCADE,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim) ON DELETE CASCADE
);

-- Masukkan data dummy ke dalam tabel users
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),
('dosen1', 'dosen123', 'dosen'),
('mhs1', 'mahasiswa123', 'mahasiswa');

-- Masukkan data dummy ke dalam tabel admin
INSERT INTO admin (user_id, nama, email) VALUES 
(1, 'Admin Kampus', 'admin@kampus.com');

-- Masukkan data dummy ke dalam tabel dosen
INSERT INTO dosen (nik, user_id, nama, gelar, lulusan, telp) VALUES
('D123', 2, 'Dr. Andi', 'S.Kom, M.T', 'Institut Teknologi', '08123456789');

-- Masukkan data dummy ke dalam tabel mahasiswa
INSERT INTO mahasiswa (nim, user_id, nama, tahun_masuk, alamat, telp) VALUES
('M001', 3, 'Budi Santoso', 2023, 'Jakarta', '08987654321');

-- Masukkan data dummy ke dalam tabel mata_kuliah
INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester) VALUES
('MK001', 'Pemrograman Web', 3, 2),
('MK002', 'Basis Data', 3, 2);

-- Masukkan data dummy ke dalam tabel krs
INSERT INTO krs (kode_matkul, nik_dosen, nim, hari, ruang) VALUES
('MK001', 'D123', 'M001', 'Senin', 'R101');
