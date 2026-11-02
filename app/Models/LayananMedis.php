<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class LayananMedis {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM layanan_medis ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM layanan_medis WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO layanan_medis (kode_layanan, nama_layanan, poli, tarif, status) 
                                    VALUES (:kode, :nama, :poli, :tarif, :status)");
        return $stmt->execute([
            ':kode'   => $data['kode_layanan'],
            ':nama'   => $data['nama_layanan'],
            ':poli'   => $data['poli'],
            ':tarif'  => $data['tarif'],
            ':status' => $data['status'] ?? 'tersedia'
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE layanan_medis SET 
                                    nama_layanan = :nama, 
                                    poli = :poli, 
                                    tarif = :tarif, 
                                    status = :status 
                                    WHERE id = :id");
        return $stmt->execute([
            ':nama'   => $data['nama_layanan'],
            ':poli'   => $data['poli'],
            ':tarif'  => $data['tarif'],
            ':status' => $data['status'],
            ':id'     => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM layanan_medis WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

