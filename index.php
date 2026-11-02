<?php
/**
 * Single Entry Point: Smart Clinic & Pharmacy ERP
 * STMIK IKMI Cirebon - Pegangan Dosen Pemrograman Web Dasar
 */

require_once __DIR__ . '/config/config.php';

// Autoloader Sederhana untuk Namespace App
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Jalankan Router Utama
\App\Core\App::run();

