<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\LayananMedis;
use App\Models\AuditLog;

class PasienController extends Controller {
    public function index(): void {
        $this->checkAuth(['admin', 'dokter', 'kasir']);

        $pasienModel  = new Pasien();
        $rmModel      = new RekamMedis();
        $layananModel = new LayananMedis();

        $pasiens    = $pasienModel->getAll();
        $kunjungan  = $rmModel->getAllWithDetails();
        $layananList = $layananModel->getAll();

        $this->render('pasien/index', [
            'title'       => 'Registrasi Pasien & Antrean Rekam Medis (Modul 2 - SI)',
            'pasiens'     => $pasiens,
            'kunjungan'   => $kunjungan,
            'layananList' => $layananList
        ]);
    }

    public function create(): void {
        $this->checkAuth(['admin', 'kasir']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_rm'         => 'RM-' . date('Y') . sprintf('%04d', rand(1, 9999)),
                'nik'           => trim($_POST['nik'] ?? ''),
                'nama_pasien'   => trim($_POST['nama_pasien'] ?? ''),
                'jenis_kelamin' => trim($_POST['jenis_kelamin'] ?? 'L'),
                'tgl_lahir'     => trim($_POST['tgl_lahir'] ?? '2000-01-01'),
                'telepon'       => trim($_POST['telepon'] ?? ''),
                'alamat'        => trim($_POST['alamat'] ?? ''),
                'jenis_pasien'  => trim($_POST['jenis_pasien'] ?? 'Umum')
            ];

            $pasienModel = new Pasien();
            $id = $pasienModel->create($data);
            if ($id > 0) {
                (new AuditLog())->log('CREATE', 'Pasien', "Mendaftarkan pasien baru: {$data['nama_pasien']} ({$data['no_rm']})");
                $this->setFlash('success', "Pasien berhasil didaftarkan dengan Nomor RM: {$data['no_rm']}");
            } else {
                $this->setFlash('danger', 'Gagal mendaftarkan pasien.');
            }
            $this->redirect('/index.php?c=pasien&m=index');
        }
    }

    public function createKunjungan(): void {
        $this->checkAuth(['admin', 'kasir']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_kunjungan'  => 'KNJ-' . date('Ymd') . sprintf('%03d', rand(1, 999)),
                'pasien_id'     => (int)($_POST['pasien_id'] ?? 0),
                'layanan_id'    => (int)($_POST['layanan_id'] ?? 0),
                'tgl_kunjungan' => trim($_POST['tgl_kunjungan'] ?? date('Y-m-d')),
                'keluhan'       => trim($_POST['keluhan'] ?? ''),
                'status_periksa'=> 'Menunggu'
            ];

            $rmModel = new RekamMedis();
            if ($rmModel->create($data)) {
                (new AuditLog())->log('CREATE', 'Antrean Pasien', "Membuat antrean kunjungan {$data['no_kunjungan']}");
                $this->setFlash('success', "Antrean kunjungan poli berhasil diterbitkan: {$data['no_kunjungan']}");
            } else {
                $this->setFlash('danger', 'Gagal menerbitkan antrean kunjungan.');
            }
            $this->redirect('/index.php?c=pasien&m=index');
        }
    }

    public function periksa(): void {
        $this->checkAuth(['admin', 'dokter']);
        $id = (int)($_GET['id'] ?? 0);
        $rmModel = new RekamMedis();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tensi'          => trim($_POST['tensi'] ?? ''),
                'suhu'           => trim($_POST['suhu'] ?? ''),
                'diagnosis'      => trim($_POST['diagnosis'] ?? ''),
                'resep_obat'     => trim($_POST['resep_obat'] ?? ''),
                'status_periksa' => trim($_POST['status_periksa'] ?? 'Menuju Kasir')
            ];

            if ($rmModel->updatePemeriksaan($id, $data)) {
                (new AuditLog())->log('UPDATE', 'Rekam Medis', "Dokter menginput rekam medis ID {$id}");
                $this->setFlash('success', 'Catatan rekam medis & resep obat berhasil disimpan!');
            } else {
                $this->setFlash('danger', 'Gagal menyimpan rekam medis.');
            }
            $this->redirect('/index.php?c=pasien&m=index');
        }

        $kunjungan = $rmModel->findByIdWithDetails($id);
        if (!$kunjungan) {
            $this->setFlash('danger', 'Data kunjungan tidak ditemukan.');
            $this->redirect('/index.php?c=pasien&m=index');
        }

        $this->render('pasien/periksa', [
            'title'     => 'Form Pemeriksaan Medis Dokter (EMR)',
            'kunjungan' => $kunjungan
        ]);
    }
}

