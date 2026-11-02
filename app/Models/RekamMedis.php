<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class RekamMedis {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllWithDetails(): array {
        $sql = "SELECT rm.*, p.no_rm, p.nama_pasien, p.jenis_kelamin, p.telepon, lm.nama_layanan, lm.poli, lm.tarif 
                FROM rekam_medis rm
                JOIN pasien p ON rm.pasien_id = p.id
                JOIN layanan_medis lm ON rm.layanan_id = lm.id
                ORDER BY rm.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findByIdWithDetails(int $id): ?array {
        $sql = "SELECT rm.*, p.no_rm, p.nik, p.nama_pasien, p.jenis_kelamin, p.tgl_lahir, p.telepon, p.alamat, p.jenis_pasien,
                       lm.kode_layanan, lm.nama_layanan, lm.poli, lm.tarif 
                FROM rekam_medis rm
                JOIN pasien p ON rm.pasien_id = p.id
                JOIN layanan_medis lm ON rm.layanan_id = lm.id
                WHERE rm.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO rekam_medis (no_kunjungan, pasien_id, layanan_id, tgl_kunjungan, keluhan, tensi, suhu, diagnosis, resep_obat, status_periksa) 
                                    VALUES (:nokun, :pid, :lid, :tgl, :kel, :tensi, :suhu, :diag, :resep, :stat)");
        return $stmt->execute([
            ':nokun' => $data['no_kunjungan'],
            ':pid'   => $data['pasien_id'],
            ':lid'   => $data['layanan_id'],
            ':tgl'   => $data['tgl_kunjungan'],
            ':kel'   => $data['keluhan'],
            ':tensi' => $data['tensi'] ?? '',
            ':suhu'  => $data['suhu'] ?? '',
            ':diag'  => $data['diagnosis'] ?? '',
            ':resep' => $data['resep_obat'] ?? '',
            ':stat'  => $data['status_periksa'] ?? 'Menunggu'
        ]);
    }

    public function updatePemeriksaan(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE rekam_medis SET 
                                    tensi = :tensi, 
                                    suhu = :suhu, 
                                    diagnosis = :diag, 
                                    resep_obat = :resep, 
                                    status_periksa = :stat 
                                    WHERE id = :id");
        return $stmt->execute([
            ':tensi' => $data['tensi'],
            ':suhu'  => $data['suhu'],
            ':diag'  => $data['diagnosis'],
            ':resep' => $data['resep_obat'],
            ':stat'  => $data['status_periksa'],
            ':id'    => $id
        ]);
    }

    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare("UPDATE rekam_medis SET status_periksa = :stat WHERE id = :id");
        return $stmt->execute([':stat' => $status, ':id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM rekam_medis WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

