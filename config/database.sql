-- ====================================================================
-- DATABASE SCHEMA: SMART KLINIK & APOTEK TERPADU (SMART CLINIC ERP)
-- STMIK IKMI Cirebon - Pegangan Dosen Pemrograman Web Dasar (SI & KA)
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `smart_klinik_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smart_klinik_db`;

-- 1. TABEL PENGGUNA & RBAC (Sistem Informasi - Auth)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `role` ENUM('admin', 'dokter', 'kasir', 'apoteker') NOT NULL DEFAULT 'admin',
  `status` ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. TABEL MASTER LAYANAN MEDIS (Sistem Informasi - Modul 1)
DROP TABLE IF EXISTS `layanan_medis`;
CREATE TABLE `layanan_medis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_layanan` VARCHAR(20) NOT NULL UNIQUE,
  `nama_layanan` VARCHAR(100) NOT NULL,
  `poli` VARCHAR(50) NOT NULL,
  `tarif` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('tersedia', 'tutup') NOT NULL DEFAULT 'tersedia',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. TABEL MASTER OBAT & FARMASI (Sistem Informasi - Modul 1)
DROP TABLE IF EXISTS `obat`;
CREATE TABLE `obat` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_obat` VARCHAR(20) NOT NULL UNIQUE,
  `nama_obat` VARCHAR(100) NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `satuan` VARCHAR(30) NOT NULL,
  `harga_beli` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `harga_jual` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `stok` INT NOT NULL DEFAULT 0,
  `stok_min` INT NOT NULL DEFAULT 10,
  `exp_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. TABEL MASTER PASIEN (Sistem Informasi - Modul 2)
DROP TABLE IF EXISTS `pasien`;
CREATE TABLE `pasien` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_rm` VARCHAR(20) NOT NULL UNIQUE,
  `nik` VARCHAR(20) NOT NULL,
  `nama_pasien` VARCHAR(100) NOT NULL,
  `jenis_kelamin` ENUM('L', 'P') NOT NULL,
  `tgl_lahir` DATE NOT NULL,
  `telepon` VARCHAR(20) NOT NULL,
  `alamat` TEXT,
  `jenis_pasien` ENUM('Umum', 'BPJS') NOT NULL DEFAULT 'Umum',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. TABEL REKAM MEDIS & KUNJUNGAN (Sistem Informasi - Modul 2)
DROP TABLE IF EXISTS `rekam_medis`;
CREATE TABLE `rekam_medis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_kunjungan` VARCHAR(25) NOT NULL UNIQUE,
  `pasien_id` INT NOT NULL,
  `layanan_id` INT NOT NULL,
  `tgl_kunjungan` DATE NOT NULL,
  `keluhan` TEXT,
  `tensi` VARCHAR(20),
  `suhu` VARCHAR(10),
  `diagnosis` VARCHAR(150),
  `resep_obat` TEXT,
  `status_periksa` ENUM('Menunggu', 'Diperiksa', 'Menuju Kasir', 'Selesai') NOT NULL DEFAULT 'Menunggu',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`pasien_id`) REFERENCES `pasien`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`layanan_id`) REFERENCES `layanan_medis`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. TABEL BAGAN AKUN STANDAR / COA (Komputerisasi Akuntansi - Modul 3)
DROP TABLE IF EXISTS `bagan_akun_coa`;
CREATE TABLE `bagan_akun_coa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_akun` VARCHAR(20) NOT NULL UNIQUE,
  `nama_akun` VARCHAR(100) NOT NULL,
  `kelompok` ENUM('Aset', 'Kewajiban', 'Modal', 'Pendapatan', 'Beban') NOT NULL,
  `saldo_normal` ENUM('Debet', 'Kredit') NOT NULL,
  `saldo_awal` DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 7. TABEL TRANSAKSI KAS & JURNAL MUTASI (Komputerisasi Akuntansi - Modul 4)
DROP TABLE IF EXISTS `transaksi_kas`;
CREATE TABLE `transaksi_kas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_transaksi` VARCHAR(30) NOT NULL UNIQUE,
  `tgl_transaksi` DATE NOT NULL,
  `akun_id` INT NOT NULL,
  `jenis_transaksi` ENUM('Kas Masuk', 'Kas Keluar') NOT NULL,
  `nominal` DECIMAL(14,2) NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `keterangan` TEXT,
  `operator` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`akun_id`) REFERENCES `bagan_akun_coa`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 8. TABEL BILLING PEMBAYARAN PASIEN (Komputerisasi Akuntansi - Modul 4)
DROP TABLE IF EXISTS `billing_pasien`;
CREATE TABLE `billing_pasien` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_faktur` VARCHAR(30) NOT NULL UNIQUE,
  `rekam_medis_id` INT NOT NULL,
  `total_layanan` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `total_obat` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `diskon` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` DECIMAL(12,2) NOT NULL,
  `nominal_bayar` DECIMAL(12,2) NOT NULL,
  `kembalian` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `metode_bayar` ENUM('Tunai', 'Transfer Bank', 'QRIS') NOT NULL DEFAULT 'Tunai',
  `status_bayar` ENUM('Lunas', 'Belum Lunas') NOT NULL DEFAULT 'Lunas',
  `kasir_user` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 9. TABEL KRITERIA SPK PENGADAAN OBAT (SI + KA - Modul 5)
DROP TABLE IF EXISTS `kriteria_spk`;
CREATE TABLE `kriteria_spk` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_kriteria` VARCHAR(10) NOT NULL UNIQUE,
  `nama_kriteria` VARCHAR(100) NOT NULL,
  `bobot` DECIMAL(5,2) NOT NULL,
  `tipe` ENUM('benefit', 'cost') NOT NULL
) ENGINE=InnoDB;

-- 10. TABEL AUDIT LOG OWASP SECURITY (SI + KA - Modul 5)
DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `username` VARCHAR(50) NOT NULL,
  `aksi` VARCHAR(50) NOT NULL,
  `modul` VARCHAR(50) NOT NULL,
  `keterangan` TEXT,
  `ip_address` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ====================================================================
-- SEED DATA AWAL (DUMMY REALISTIS)
-- ====================================================================

-- 1. Pengguna (Password default: admin123 -> $2y$10$NW1mrovrRf3sLMDqgE2rqOicgbBFqB8Aow2CGdS71PESgebJnqNoC atau hash berypt)
INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `role`, `status`) VALUES
('admin', '$2y$10$NW1mrovrRf3sLMDqgE2rqOicgbBFqB8Aow2CGdS71PESgebJnqNoC', 'Dr. Raden H. Setiawan, Sp.PK', 'admin', 'aktif'),
('dokter1', '$2y$10$NW1mrovrRf3sLMDqgE2rqOicgbBFqB8Aow2CGdS71PESgebJnqNoC', 'dr. Annisa Larasati', 'dokter', 'aktif'),
('kasir1', '$2y$10$NW1mrovrRf3sLMDqgE2rqOicgbBFqB8Aow2CGdS71PESgebJnqNoC', 'Siti Rahmawati, S.Ak', 'kasir', 'aktif'),
('apoteker1', '$2y$10$NW1mrovrRf3sLMDqgE2rqOicgbBFqB8Aow2CGdS71PESgebJnqNoC', 'Fajar Pratama, S.Farm', 'apoteker', 'aktif');

-- 2. Layanan Medis
INSERT INTO `layanan_medis` (`kode_layanan`, `nama_layanan`, `poli`, `tarif`, `status`) VALUES
('POL-001', 'Pemeriksaan Dokter Umum', 'Poli Umum', 50000.00, 'tersedia'),
('POL-002', 'Pemeriksaan Kesehatan Gigi', 'Poli Gigi', 75000.00, 'tersedia'),
('POL-003', 'Konsultasi Ibu & Anak', 'Poli KIA', 65000.00, 'tersedia'),
('LAB-001', 'Cek Gula Darah & Kolesterol', 'Laboratorium', 45000.00, 'tersedia'),
('TND-001', 'Tindakan Rawat Luka Ringan', 'Tindakan Medis', 35000.00, 'tersedia');

-- 3. Master Obat
INSERT INTO `obat` (`kode_obat`, `nama_obat`, `kategori`, `satuan`, `harga_beli`, `harga_jual`, `stok`, `stok_min`, `exp_date`) VALUES
('OBT-001', 'Paracetamol 500mg', 'Analgesik / Antipiretik', 'Strip', 3500.00, 7000.00, 120, 20, '2027-08-15'),
('OBT-002', 'Amoxicillin 500mg', 'Antibiotik Keras', 'Strip', 6000.00, 12000.00, 45, 15, '2026-12-30'),
('OBT-003', 'Antasida Doen Suspensi', 'Saluran Cerna', 'Botol', 8000.00, 15000.00, 30, 10, '2027-05-20'),
('OBT-004', 'Cetirizine 10mg', 'Antihistamin Alergi', 'Strip', 4000.00, 8500.00, 18, 20, '2026-11-25'),
('OBT-005', 'Metformin 500mg', 'Antidiabetes Oral', 'Strip', 5000.00, 9500.00, 8, 25, '2027-01-10'),
('OBT-006', 'Vitamin C 500mg IPI', 'Suplemen Imunitas', 'Botol', 7000.00, 13000.00, 90, 15, '2028-03-01');

-- 4. Pasien
INSERT INTO `pasien` (`no_rm`, `nik`, `nama_pasien`, `jenis_kelamin`, `tgl_lahir`, `telepon`, `alamat`, `jenis_pasien`) VALUES
('RM-2026001', '3209121508920001', 'Budi Santoso', 'L', '1992-08-15', '081234567890', 'Jl. Tuparev No. 45 Cirebon', 'Umum'),
('RM-2026002', '3209124403980003', 'Dewi Anggraeni', 'P', '1998-03-04', '085712349988', 'Jl. Pemuda No. 12 Kesambi Cirebon', 'BPJS'),
('RM-2026003', '3209140211850002', 'Hendra Kurniawan', 'L', '1985-11-02', '081398765432', 'Perumahan Graha Indah Kedawung', 'Umum'),
('RM-2026004', '3209156607010005', 'Siti Nurhaliza', 'P', '2001-07-26', '082145671122', 'Jl. Brigjen Dharsono No. 88 Cirebon', 'Umum');

-- 5. Rekam Medis
INSERT INTO `rekam_medis` (`no_kunjungan`, `pasien_id`, `layanan_id`, `tgl_kunjungan`, `keluhan`, `tensi`, `suhu`, `diagnosis`, `resep_obat`, `status_periksa`) VALUES
('KNJ-20261101', 1, 1, '2026-11-01', 'Demam tinggi 2 hari, sakit kepala berdenyut', '120/80', '38.5 C', 'Febris Susp. Viral Infection', 'Paracetamol 500mg (3x1), Vitamin C 500mg (1x1)', 'Selesai'),
('KNJ-20261102', 2, 1, '2026-11-02', 'Nyeri lambung perih dan mual setelah makan', '110/70', '36.8 C', 'Dispepsia Sindrom / Gastritis', 'Antasida Doen (3x1 Cth ac)', 'Menuju Kasir'),
('KNJ-20261103', 3, 2, '2026-11-02', 'Gigi geraham kanan bawah ngilu berdenyut', '130/85', '36.5 C', 'Pulpitis Kronis Gigi 46', 'Amoxicillin 500mg (3x1), Paracetamol 500mg (3x1)', 'Diperiksa');

-- 6. Bagan Akun (COA)
INSERT INTO `bagan_akun_coa` (`kode_akun`, `nama_akun`, `kelompok`, `saldo_normal`, `saldo_awal`, `status`) VALUES
('1101', 'Kas Kasir Klinik', 'Aset', 'Debet', 3500000.00, 'aktif'),
('1102', 'Kas Utama / Operasional', 'Aset', 'Debet', 15000000.00, 'aktif'),
('1103', 'Bank BJB Klinik', 'Aset', 'Debet', 45000000.00, 'aktif'),
('1104', 'Piutang Klaim Pasien BPJS', 'Aset', 'Debet', 8500000.00, 'aktif'),
('1105', 'Persediaan Obat Farmasi', 'Aset', 'Debet', 18500000.00, 'aktif'),
('2101', 'Utang Usaha Distributor PBF', 'Kewajiban', 'Kredit', 6000000.00, 'aktif'),
('3101', 'Modal Awal Pendirian Klinik', 'Modal', 'Kredit', 75000000.00, 'aktif'),
('4101', 'Pendapatan Layanan & Tindakan Medis', 'Pendapatan', 'Kredit', 0.00, 'aktif'),
('4102', 'Pendapatan Penjualan Obat Apotek', 'Pendapatan', 'Kredit', 0.00, 'aktif'),
('5101', 'Beban Pengadaan Obat & Alkes', 'Beban', 'Debet', 0.00, 'aktif'),
('5102', 'Beban Honor Dokter & Paramedis', 'Beban', 'Debet', 0.00, 'aktif'),
('5103', 'Beban Listrik, Air & WiFi Klinik', 'Beban', 'Debet', 0.00, 'aktif');

-- 7. Transaksi Kas Awal
INSERT INTO `transaksi_kas` (`no_transaksi`, `tgl_transaksi`, `akun_id`, `jenis_transaksi`, `nominal`, `kategori`, `keterangan`, `operator`) VALUES
('KAS-IN-20261101', '2026-11-01', 1, 'Kas Masuk', 70000.00, 'Layanan Medis', 'Pembayaran pemeriksaan Pasien Budi Santoso', 'kasir1'),
('KAS-OUT-20261101', '2026-11-01', 2, 'Kas Keluar', 450000.00, 'Operasional', 'Pembayaran tagihan listrik PLN Klinik', 'kasir1'),
('KAS-IN-20261102', '2026-11-02', 1, 'Kas Masuk', 95000.00, 'Penjualan Obat', 'Penerimaan kas penjualan obat resep', 'kasir1');

-- 8. Billing Pasien
INSERT INTO `billing_pasien` (`no_faktur`, `rekam_medis_id`, `total_layanan`, `total_obat`, `diskon`, `grand_total`, `nominal_bayar`, `kembalian`, `metode_bayar`, `status_bayar`, `kasir_user`) VALUES
('INV-202611-001', 1, 50000.00, 20000.00, 0.00, 70000.00, 100000.00, 30000.00, 'Tunai', 'Lunas', 'kasir1');

-- 9. Kriteria SPK Pengadaan Obat SAW
INSERT INTO `kriteria_spk` (`kode_kriteria`, `nama_kriteria`, `bobot`, `tipe`) VALUES
('C1', 'Sisa Stok Fisik (Makin Sedikit Makin Prioritas)', 0.35, 'cost'),
('C2', 'Kecepatan Terjual / Fast Moving (Jumlah Resep)', 0.30, 'benefit'),
('C3', 'Urgensi Penyakit / Critical Level', 0.20, 'benefit'),
('C4', 'Harga Beli Distributor (Biaya Pengadaan)', 0.15, 'cost');

-- 10. Audit Logs
INSERT INTO `audit_logs` (`user_id`, `username`, `aksi`, `modul`, `keterangan`, `ip_address`) VALUES
(1, 'admin', 'LOGIN', 'Autentikasi', 'Login berhasil ke Dashboard Admin', '127.0.0.1'),
(1, 'admin', 'INSERT', 'Master Obat', 'Menambahkan data obat Cetirizine 10mg', '127.0.0.1');

