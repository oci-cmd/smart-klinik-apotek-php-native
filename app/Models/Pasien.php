<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Pasien {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM pasien ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM pasien WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("INSERT INTO pasien (no_rm, nik, nama_pasien, jenis_kelamin, tgl_lahir, telepon, alamat, jenis_pasien) 
                                    VALUES (:norm, :nik, :nama, :jk, :tgl, :telp, :alamat, :jenis)");
        $stmt->execute([
            ':norm'   => $data['no_rm'],
            ':nik'    => $data['nik'],
            ':nama'   => $data['nama_pasien'],
            ':jk'     => $data['jenis_kelamin'],
            ':tgl'    => $data['tgl_lahir'],
            ':telp'   => $data['telepon'],
            ':alamat' => $data['alamat'],
            ':jenis'  => $data['jenis_pasien'] ?? 'Umum'
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE pasien SET 
                                    nik = :nik, 
                                    nama_pasien = :nama, 
                                    jenis_kelamin = :jk, 
                                    tgl_lahir = :tgl, 
                                    telepon = :telp, 
                                    alamat = :alamat, 
                                    jenis_pasien = :jenis 
                                    WHERE id = :id");
        return $stmt->execute([
            ':nik'    => $data['nik'],
            ':nama'   => $data['nama_pasien'],
            ':jk'     => $data['jenis_kelamin'],
            ':tgl'    => $data['tgl_lahir'],
            ':telp'   => $data['telepon'],
            ':alamat' => $data['alamat'],
            ':jenis'  => $data['jenis_pasien'],
            ':id'     => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM pasien WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

