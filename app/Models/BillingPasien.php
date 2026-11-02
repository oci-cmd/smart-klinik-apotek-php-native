<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class BillingPasien {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllWithDetails(): array {
        $sql = "SELECT bp.*, rm.no_kunjungan, rm.tgl_kunjungan, p.no_rm, p.nama_pasien 
                FROM billing_pasien bp
                JOIN rekam_medis rm ON bp.rekam_medis_id = rm.id
                JOIN pasien p ON rm.pasien_id = p.id
                ORDER BY bp.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $sql = "SELECT bp.*, rm.no_kunjungan, rm.tgl_kunjungan, rm.diagnosis, rm.resep_obat,
                       p.no_rm, p.nama_pasien, p.telepon, p.alamat, lm.nama_layanan, lm.tarif 
                FROM billing_pasien bp
                JOIN rekam_medis rm ON bp.rekam_medis_id = rm.id
                JOIN pasien p ON rm.pasien_id = p.id
                JOIN layanan_medis lm ON rm.layanan_id = lm.id
                WHERE bp.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO billing_pasien 
                (no_faktur, rekam_medis_id, total_layanan, total_obat, diskon, grand_total, nominal_bayar, kembalian, metode_bayar, status_bayar, kasir_user) 
                VALUES (:nofak, :rmid, :tlay, :tobt, :disc, :gtot, :bayar, :kembali, :metode, :stat, :kasir)");
            $stmt->execute([
                ':nofak'   => $data['no_faktur'],
                ':rmid'    => $data['rekam_medis_id'],
                ':tlay'    => $data['total_layanan'],
                ':tobt'    => $data['total_obat'],
                ':disc'    => $data['diskon'],
                ':gtot'    => $data['grand_total'],
                ':bayar'   => $data['nominal_bayar'],
                ':kembali' => $data['kembalian'],
                ':metode'  => $data['metode_bayar'] ?? 'Tunai',
                ':stat'    => 'Lunas',
                ':kasir'   => $data['kasir_user']
            ]);

            // Update status rekam medis menjadi Selesai
            $upd = $this->db->prepare("UPDATE rekam_medis SET status_periksa = 'Selesai' WHERE id = :rmid");
            $upd->execute([':rmid' => $data['rekam_medis_id']]);

            // Catat otomatis ke Kas Masuk (Akun 1101 - Kas Kasir Klinik)
            $transKas = $this->db->prepare("INSERT INTO transaksi_kas 
                (no_transaksi, tgl_transaksi, akun_id, jenis_transaksi, nominal, kategori, keterangan, operator) 
                VALUES (:notr, CURDATE(), 1, 'Kas Masuk', :nom, 'Layanan Medis', :ket, :op)");
            $transKas->execute([
                ':notr' => 'KAS-IN-' . time(),
                ':nom'  => $data['grand_total'],
                ':ket'  => "Pembayaran Faktur " . $data['no_faktur'],
                ':op'   => $data['kasir_user']
            ]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}

