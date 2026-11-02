<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Security;
use PDO;

class User {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :u AND status = 'aktif' LIMIT 1");
        $stmt->execute([':u' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updatePassword(int $id, string $newPassword): bool {
        $hash = Security::hashPassword($newPassword);
        $stmt = $this->db->prepare("UPDATE users SET password = :p WHERE id = :id");
        return $stmt->execute([':p' => $hash, ':id' => $id]);
    }
}

