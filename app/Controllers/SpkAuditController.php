<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\SpkSaw;
use App\Models\AuditLog;

class SpkAuditController extends Controller {
    public function index(): void {
        $this->checkAuth(['admin', 'dokter', 'apoteker']);

        $spkModel   = new SpkSaw();
        $auditModel = new AuditLog();

        $kriteria   = $spkModel->getKriteria();
        $prioritas  = $spkModel->calculatePrioritas();
        $logs       = $auditModel->getAll(60);

        $this->render('spk/index', [
            'title'     => 'SPK Prioritas Pengadaan Obat (SAW) & Audit Log OWASP (Modul 5 - SI/KA)',
            'kriteria'  => $kriteria,
            'prioritas' => $prioritas,
            'logs'      => $logs
        ]);
    }
}

