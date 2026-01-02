-- Buat Database
CREATE DATABASE IF NOT EXISTS db_mahasiswa;
USE db_mahasiswa;

-- Buat Table
CREATE TABLE mahasiswa (
    id_mahasiswa INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    program_studi VARCHAR(50),
    fakultas VARCHAR(50),
    alamat TEXT,
    nomor_hp VARCHAR(20),
    email VARCHAR(50),
    angkatan YEAR,
    status_mahasiswa ENUM('Aktif', 'Cuti', 'Lulus', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa 
(nim, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, program_studi, fakultas, alamat, nomor_hp, email, angkatan, status_mahasiswa)
VALUES
('20210001', 'Budi Santoso', 'Laki-laki', 'Jakarta', '2003-01-15', 'Teknik Informatika', 'Fakultas Teknik', 'Jl. Merdeka No. 10, Jakarta', '081234567801', 'budi.santoso@email.com', 2021, 'Aktif'),
('20210002', 'Siti Aisyah', 'Perempuan', 'Bandung', '2003-03-22', 'Sistem Informasi', 'Fakultas Teknik', 'Jl. Asia Afrika No. 21, Bandung', '081234567802', 'siti.aisyah@email.com', 2021, 'Aktif'),
('20210003', 'Andi Pratama', 'Laki-laki', 'Surabaya', '2002-11-08', 'Teknik Informatika', 'Fakultas Teknik', 'Jl. Pahlawan No. 5, Surabaya', '081234567803', 'andi.pratama@email.com', 2021, 'Aktif'),
('20210004', 'Dewi Lestari', 'Perempuan', 'Yogyakarta', '2003-07-19', 'Manajemen', 'Fakultas Ekonomi', 'Jl. Malioboro No. 77, Yogyakarta', '081234567804', 'dewi.lestari@email.com', 2021, 'Aktif'),
('20210005', 'Rizky Hidayat', 'Laki-laki', 'Medan', '2002-12-01', 'Akuntansi', 'Fakultas Ekonomi', 'Jl. Gatot Subroto No. 18, Medan', '081234567805', 'rizky.hidayat@email.com', 2021, 'Cuti'),
('20200006', 'Putri Maharani', 'Perempuan', 'Semarang', '2002-05-30', 'Ilmu Komunikasi', 'Fakultas Ilmu Sosial', 'Jl. Pandanaran No. 33, Semarang', '081234567806', 'putri.maharani@email.com', 2020, 'Aktif'),
('20200007', 'Fajar Nugroho', 'Laki-laki', 'Solo', '2002-02-14', 'Teknik Elektro', 'Fakultas Teknik', 'Jl. Slamet Riyadi No. 45, Solo', '081234567807', 'fajar.nugroho@email.com', 2020, 'Lulus'),
('20190008', 'Nurul Hasanah', 'Perempuan', 'Makassar', '2001-09-09', 'Hukum', 'Fakultas Hukum', 'Jl. Pettarani No. 9, Makassar', '081234567808', 'nurul.hasanah@email.com', 2019, 'Lulus'),
('20190009', 'Agus Setiawan', 'Laki-laki', 'Palembang', '2001-04-25', 'Administrasi Publik', 'Fakultas Ilmu Sosial', 'Jl. Sudirman No. 12, Palembang', '081234567809', 'agus.setiawan@email.com', 2019, 'Nonaktif'),
('20220010', 'Intan Permata Sari', 'Perempuan', 'Denpasar', '2004-06-18', 'Pariwisata', 'Fakultas Pariwisata', 'Jl. Sunset Road No. 88, Denpasar', '081234567810', 'intan.permata@email.com', 2022, 'Aktif');
