<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class TransaksiKas {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllWithAccount(): array {
        $sql = "SELECT tk.*, ba.kode_akun, ba.nama_akun, ba.kelompok 
                FROM transaksi_kas tk
                JOIN bagan_akun_coa ba ON tk.akun_id = ba.id
                ORDER BY tk.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getSummaryKas(): array {
        $sql = "SELECT 
                    SUM(CASE WHEN jenis_transaksi = 'Kas Masuk' THEN nominal ELSE 0 END) AS total_masuk,
                    SUM(CASE WHEN jenis_transaksi = 'Kas Keluar' THEN nominal ELSE 0 END) AS total_keluar
                FROM transaksi_kas";
        $stmt = $this->db->query($sql);
        $res = $stmt->fetch();
        $totalMasuk = (float)($res['total_masuk'] ?? 0);
        $totalKeluar = (float)($res['total_keluar'] ?? 0);

        // Ambil saldo awal kas (1101, 1102, 1103)
        $stmtAwal = $this->db->query("SELECT SUM(saldo_awal) FROM bagan_akun_coa WHERE kode_akun IN ('1101', '1102', '1103')");
        $saldoAwal = (float)$stmtAwal->fetchColumn();

        return [
            'total_masuk'  => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo_akhir'  => $saldoAwal + $totalMasuk - $totalKeluar
        ];
    }

    public function create(array $data): bool {
        // Validasi jika kas keluar, saldo tidak boleh minus
        if ($data['jenis_transaksi'] === 'Kas Keluar') {
            $summary = $this->getSummaryKas();
            if ($summary['saldo_akhir'] < (float)$data['nominal']) {
                return false; // Saldo kas tidak mencukupi (PSAK validation)
            }
        }

        $stmt = $this->db->prepare("INSERT INTO transaksi_kas (no_transaksi, tgl_transaksi, akun_id, jenis_transaksi, nominal, kategori, keterangan, operator) 
                                    VALUES (:notr, :tgl, :aid, :jenis, :nom, :kat, :ket, :op)");
        return $stmt->execute([
            ':notr'  => $data['no_transaksi'],
            ':tgl'   => $data['tgl_kunjungan'] ?? date('Y-m-d'),
            ':aid'   => $data['akun_id'],
            ':jenis' => $data['jenis_transaksi'],
            ':nom'   => $data['nominal'],
            ':kat'   => $data['kategori'],
            ':ket'   => $data['keterangan'],
            ':op'    => $data['operator']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM transaksi_kas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

