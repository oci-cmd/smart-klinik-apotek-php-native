<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database (Singleton Pattern)
 * Menggunakan PDO Strict Mode: Prepared Statement murni & Exception Handling
 */
class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false, // WAJIB FALSE untuk menutup celah SQL Injection
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                die("<div style='font-family:sans-serif;padding:24px;background:#FEF2F2;border:1px solid #FCA5A5;color:#991B1B;border-radius:12px;max-width:700px;margin:40px auto;'>"
                    . "<h3 style='margin-top:0;'>⚠️ Gagal Terhubung ke Basis Data MySQL!</h3>"
                    . "<p>Pastikan MySQL server aktif di port " . DB_PORT . " dan database <strong>" . DB_NAME . "</strong> sudah diinisialisasi.</p>"
                    . "<p>Silakan buka file <a href='setup.php' style='color:#2563EB;font-weight:bold;'>setup.php</a> untuk migrasi otomatis basis data satu klik.</p>"
                    . "<small style='color:#6B7280;'>Pesan Teknis: " . htmlspecialchars($e->getMessage()) . "</small>"
                    . "</div>");
            }
        }

        return self::$instance;
    }
}

