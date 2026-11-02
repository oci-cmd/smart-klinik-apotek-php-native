<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Security;
use PDO;

class AuditLog {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(int $limit = 50): array {
        $stmt = $this->db->prepare("SELECT * FROM audit_logs ORDER BY id DESC LIMIT :lim");
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function log(string $aksi, string $modul, string $keterangan): void {
        Security::initSession();
        $userId   = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['username'] ?? 'GUEST';
        $ip       = Security::getClientIp();

        $stmt = $this->db->prepare("INSERT INTO audit_logs (user_id, username, aksi, modul, keterangan, ip_address) 
                                    VALUES (:uid, :uname, :aksi, :modul, :ket, :ip)");
        $stmt->execute([
            ':uid'   => $userId,
            ':uname' => $username,
            ':aksi'  => $aksi,
            ':modul' => $modul,
            ':ket'   => $keterangan,
            ':ip'    => $ip
        ]);
    }
}

