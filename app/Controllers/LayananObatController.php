<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\LayananMedis;
use App\Models\Obat;
use App\Models\AuditLog;

class LayananObatController extends Controller {
    public function index(): void {
        $this->checkAuth(['admin', 'dokter', 'apoteker']);

        $obatModel    = new Obat();
        $layananModel = new LayananMedis();

        $obats   = $obatModel->getAll();
        $layanan = $layananModel->getAll();

        $this->render('obat/index', [
            'title'   => 'Katalog Layanan Medis & Obat Farmasi (Modul 1 - SI)',
            'obats'   => $obats,
            'layanan' => $layanan
        ]);
    }

    public function createObat(): void {
        $this->checkAuth(['admin', 'apoteker']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kode_obat'  => trim($_POST['kode_obat'] ?? ''),
                'nama_obat'  => trim($_POST['nama_obat'] ?? ''),
                'kategori'   => trim($_POST['kategori'] ?? ''),
                'satuan'     => trim($_POST['satuan'] ?? ''),
                'harga_beli' => (float)($_POST['harga_beli'] ?? 0),
                'harga_jual' => (float)($_POST['harga_jual'] ?? 0),
                'stok'       => (int)($_POST['stok'] ?? 0),
                'stok_min'   => (int)($_POST['stok_min'] ?? 5),
                'exp_date'   => trim($_POST['exp_date'] ?? date('Y-m-d'))
            ];

            $obatModel = new Obat();
            if ($obatModel->create($data)) {
                (new AuditLog())->log('CREATE', 'Master Obat', "Menambah obat {$data['nama_obat']}");
                $this->setFlash('success', 'Data obat baru berhasil disimpan ke katalog!');
            } else {
                $this->setFlash('danger', 'Gagal menambahkan obat. Pastikan kode obat belum pernah digunakan.');
            }
            $this->redirect('/index.php?c=layananObat&m=index');
        }
    }

    public function editObat(): void {
        $this->checkAuth(['admin', 'apoteker']);
        $id = (int)($_GET['id'] ?? 0);
        $obatModel = new Obat();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_obat'  => trim($_POST['nama_obat'] ?? ''),
                'kategori'   => trim($_POST['kategori'] ?? ''),
                'satuan'     => trim($_POST['satuan'] ?? ''),
                'harga_beli' => (float)($_POST['harga_beli'] ?? 0),
                'harga_jual' => (float)($_POST['harga_jual'] ?? 0),
                'stok'       => (int)($_POST['stok'] ?? 0),
                'stok_min'   => (int)($_POST['stok_min'] ?? 5),
                'exp_date'   => trim($_POST['exp_date'] ?? date('Y-m-d'))
            ];

            if ($obatModel->update($id, $data)) {
                (new AuditLog())->log('UPDATE', 'Master Obat', "Mengubah data obat ID {$id}");
                $this->setFlash('success', 'Perubahan data obat berhasil diperbarui!');
            } else {
                $this->setFlash('danger', 'Gagal memperbarui data obat.');
            }
            $this->redirect('/index.php?c=layananObat&m=index');
        }

        $obat = $obatModel->findById($id);
        if (!$obat) {
            $this->setFlash('danger', 'Obat tidak ditemukan.');
            $this->redirect('/index.php?c=layananObat&m=index');
        }

        $this->render('obat/edit', [
            'title' => 'Edit Master Obat',
            'obat'  => $obat
        ]);
    }

    public function deleteObat(): void {
        $this->checkAuth(['admin', 'apoteker']);
        $id = (int)($_GET['id'] ?? 0);
        $obatModel = new Obat();

        if ($obatModel->delete($id)) {
            (new AuditLog())->log('DELETE', 'Master Obat', "Menghapus obat ID {$id}");
            $this->setFlash('success', 'Data obat berhasil dihapus.');
        } else {
            $this->setFlash('danger', 'Gagal menghapus data obat.');
        }
        $this->redirect('/index.php?c=layananObat&m=index');
    }

    public function createLayanan(): void {
        $this->checkAuth(['admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kode_layanan' => trim($_POST['kode_layanan'] ?? ''),
                'nama_layanan' => trim($_POST['nama_layanan'] ?? ''),
                'poli'         => trim($_POST['poli'] ?? ''),
                'tarif'        => (float)($_POST['tarif'] ?? 0),
                'status'       => trim($_POST['status'] ?? 'tersedia')
            ];

            $layananModel = new LayananMedis();
            if ($layananModel->create($data)) {
                (new AuditLog())->log('CREATE', 'Layanan Medis', "Menambah layanan {$data['nama_layanan']}");
                $this->setFlash('success', 'Layanan poli medis berhasil ditambahkan!');
            } else {
                $this->setFlash('danger', 'Gagal menambahkan layanan poli.');
            }
            $this->redirect('/index.php?c=layananObat&m=index');
        }
    }

    public function deleteLayanan(): void {
        $this->checkAuth(['admin']);
        $id = (int)($_GET['id'] ?? 0);
        $layananModel = new LayananMedis();

        if ($layananModel->delete($id)) {
            (new AuditLog())->log('DELETE', 'Layanan Medis', "Menghapus layanan medis ID {$id}");
            $this->setFlash('success', 'Layanan medis berhasil dihapus.');
        } else {
            $this->setFlash('danger', 'Gagal menghapus layanan medis.');
        }
        $this->redirect('/index.php?c=layananObat&m=index');
    }
}

