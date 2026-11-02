<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Obat {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM obat ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM obat WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO obat (kode_obat, nama_obat, kategori, satuan, harga_beli, harga_jual, stok, stok_min, exp_date) 
                                    VALUES (:kode, :nama, :kat, :sat, :hb, :hj, :stok, :min, :exp)");
        return $stmt->execute([
            ':kode' => $data['kode_obat'],
            ':nama' => $data['nama_obat'],
            ':kat'  => $data['kategori'],
            ':sat'  => $data['satuan'],
            ':hb'   => $data['harga_beli'],
            ':hj'   => $data['harga_jual'],
            ':stok' => $data['stok'],
            ':min'  => $data['stok_min'],
            ':exp'  => $data['exp_date']
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE obat SET 
                                    nama_obat = :nama, 
                                    kategori = :kat, 
                                    satuan = :sat, 
                                    harga_beli = :hb, 
                                    harga_jual = :hj, 
                                    stok = :stok, 
                                    stok_min = :min, 
                                    exp_date = :exp 
                                    WHERE id = :id");
        return $stmt->execute([
            ':nama' => $data['nama_obat'],
            ':kat'  => $data['kategori'],
            ':sat'  => $data['satuan'],
            ':hb'   => $data['harga_beli'],
            ':hj'   => $data['harga_jual'],
            ':stok' => $data['stok'],
            ':min'  => $data['stok_min'],
            ':exp'  => $data['exp_date'],
            ':id'   => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM obat WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getLowStock(): array {
        $stmt = $this->db->query("SELECT * FROM obat WHERE stok <= stok_min ORDER BY stok ASC");
        return $stmt->fetchAll();
    }

    public function getExpiringSoon(): array {
        $stmt = $this->db->query("SELECT * FROM obat WHERE exp_date <= DATE_ADD(CURDATE(), INTERVAL 60 DAY) ORDER BY exp_date ASC");
        return $stmt->fetchAll();
    }
}

