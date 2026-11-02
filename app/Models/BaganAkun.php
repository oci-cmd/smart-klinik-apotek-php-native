<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class BaganAkun {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM bagan_akun_coa ORDER BY kode_akun ASC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM bagan_akun_coa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO bagan_akun_coa (kode_akun, nama_akun, kelompok, saldo_normal, saldo_awal, status) 
                                    VALUES (:kode, :nama, :kel, :sn, :sa, :stat)");
        return $stmt->execute([
            ':kode' => $data['kode_akun'],
            ':nama' => $data['nama_akun'],
            ':kel'  => $data['kelompok'],
            ':sn'   => $data['saldo_normal'],
            ':sa'   => $data['saldo_awal'] ?? 0,
            ':stat' => $data['status'] ?? 'aktif'
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE bagan_akun_coa SET 
                                    nama_akun = :nama, 
                                    kelompok = :kel, 
                                    saldo_normal = :sn, 
                                    status = :stat 
                                    WHERE id = :id");
        return $stmt->execute([
            ':nama' => $data['nama_akun'],
            ':kel'  => $data['kelompok'],
            ':sn'   => $data['saldo_normal'],
            ':stat' => $data['status'],
            ':id'   => $id
        ]);
    }

    public function delete(int $id): bool {
        // Cek apakah akun memiliki transaksi
        $chk = $this->db->prepare("SELECT COUNT(*) FROM transaksi_kas WHERE akun_id = :id");
        $chk->execute([':id' => $id]);
        if ($chk->fetchColumn() > 0) {
            return false; // Ditolak karena integritas data finansial
        }
        $stmt = $this->db->prepare("DELETE FROM bagan_akun_coa WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

