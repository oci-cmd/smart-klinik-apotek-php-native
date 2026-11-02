<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class SpkSaw {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getKriteria(): array {
        $stmt = $this->db->query("SELECT * FROM kriteria_spk ORDER BY kode_kriteria ASC");
        return $stmt->fetchAll();
    }

    /**
     * Hitung SPK Metode SAW untuk Prioritas Pengadaan Obat
     * Kriteria:
     * C1 = Sisa Stok Fisik (Cost - makin sedikit makin tinggi prioritas)
     * C2 = Kecepatan Terjual / Fast Moving (Benefit - makin laku makin prioritas)
     * C3 = Urgensi Medis (Benefit - skala 1-100)
     * C4 = Harga Beli Distributor (Cost - makin ekonomis makin diprioritaskan)
     */
    public function calculatePrioritas(): array {
        // Ambil daftar obat
        $stmtObat = $this->db->query("SELECT id, kode_obat, nama_obat, stok, stok_min, harga_beli, harga_jual FROM obat");
        $obats = $stmtObat->fetchAll();
        if (empty($obats)) return [];

        // Simulasi nilai kriteria matriks keputusan X
        $matrixX = [];
        foreach ($obats as $o) {
            // Nilai C1: Stok saat ini
            $c1 = max(1, (int)$o['stok']); 
            // Nilai C2: Frekuensi resep (perkiraan 100 - stok_min)
            $c2 = max(10, 100 - (int)$o['stok']); 
            // Nilai C3: Urgensi Medis (Antibiotik/Jantung/Analgesik = 80-95)
            $c3 = (str_contains(strtolower($o['nama_obat']), 'amoxicillin') || str_contains(strtolower($o['nama_obat']), 'metformin')) ? 90 : 75;
            // Nilai C4: Harga Beli
            $c4 = (float)$o['harga_beli'];

            $matrixX[] = [
                'id'         => $o['id'],
                'kode_obat'  => $o['kode_obat'],
                'nama_obat'  => $o['nama_obat'],
                'stok'       => $o['stok'],
                'harga_beli' => $o['harga_beli'],
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3,
                'c4' => $c4
            ];
        }

        // Cari Nilai Min & Max per kriteria
        $minC1 = min(array_column($matrixX, 'c1'));
        $maxC2 = max(array_column($matrixX, 'c2'));
        $maxC3 = max(array_column($matrixX, 'c3'));
        $minC4 = min(array_column($matrixX, 'c4'));

        // Ambil bobot kriteria
        $bobot = [
            'c1' => 0.35,
            'c2' => 0.30,
            'c3' => 0.20,
            'c4' => 0.15
        ];

        // Normalisasi Matriks R dan Hitung Nilai Preferensi V
        $results = [];
        foreach ($matrixX as $row) {
            // Cost: min / x
            $r1 = $minC1 / $row['c1'];
            // Benefit: x / max
            $r2 = $row['c2'] / $maxC2;
            // Benefit: x / max
            $r3 = $row['c3'] / $maxC3;
            // Cost: min / x
            $r4 = $minC4 / $row['c4'];

            // Nilai Preferensi Akhir V = sum(W * R)
            $scoreV = ($bobot['c1'] * $r1) + ($bobot['c2'] * $r2) + ($bobot['c3'] * $r3) + ($bobot['c4'] * $r4);

            $results[] = [
                'id'         => $row['id'],
                'kode_obat'  => $row['kode_obat'],
                'nama_obat'  => $row['nama_obat'],
                'stok'       => $row['stok'],
                'harga_beli' => $row['harga_beli'],
                'r1'         => round($r1, 3),
                'r2'         => round($r2, 3),
                'r3'         => round($r3, 3),
                'r4'         => round($r4, 3),
                'score_v'    => round($scoreV, 4),
                'persen'     => round($scoreV * 100, 1)
            ];
        }

        // Urutkan dari nilai V tertinggi ke terendah (Ranking 1 adalah paling prioritas)
        usort($results, fn($a, $b) => $b['score_v'] <=> $a['score_v']);

        return $results;
    }
}

