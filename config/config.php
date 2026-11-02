<?php
/**
 * Konfigurasi Utama Aplikasi: Smart Clinic & Pharmacy ERP
 * STMIK IKMI Cirebon - Pegangan Dosen Pemrograman Web Dasar
 */

// Konfigurasi Database (Default XAMPP / MAMP / Native)
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'smart_klinik_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL otomatis sesuai lokasi server
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = rtrim($protocol . $host . $scriptDir, '/');

define('BASE_URL', $baseUrl);
define('APP_NAME', 'Smart Clinic & Pharmacy ERP');
define('APP_TAGLINE', 'Sistem Terpadu Manajemen Klinik & Komputerisasi Akuntansi Farmasi');
define('APP_VERSION', '1.0.0 (Release 2026)');
define('CAMPUS_NAME', 'STMIK IKMI Cirebon');
define('ACADEMIC_YEAR', 'Semester Ganjil 2026/2027');

