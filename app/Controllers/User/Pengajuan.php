<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;
use App\Models\ActivityLogModel;
use App\Models\KasSaldoModel;

class Pengajuan extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $session = session();

        $data['pengajuan'] = $model
            ->where('user_id', $session->get('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('user/pengajuan/index', $data);
    }

    public function create()
    {
        helper(['form']);
        return view('user/pengajuan/create');
    }

    public function store()
    {
        helper(['form']);

        $rules = [
            'nominal'    => 'required|numeric',
            'keterangan' => 'required',
            'deadline'   => 'permit_empty|valid_date',
            'tipe'       => 'required'
        ];

        if ($this->validate($rules)) {
            $session         = session();
            $pengajuanModel  = new PengajuanModel();
            $logModel        = new ActivityLogModel();
            $kasKeluarModel  = new KasKeluarModel();
            $kasSaldoModel   = new KasSaldoModel();

            $nominal = (float) $this->request->getVar('nominal');

            // ✅ Ambil saldo terakhir dari tabel kas_saldo dengan fallback ke 0
            $saldoData = $kasSaldoModel->orderBy('id', 'DESC')->first();
            $saldoAdmin = $saldoData['saldo_akhir'] ?? 0;

            // ✅ Pastikan hasilnya numerik
            $saldoAdmin = (float) $saldoAdmin;

            // ✅ Cegah jika saldo kosong atau tidak cukup
            if ($saldoAdmin <= 0 || $saldoAdmin < $nominal) {
                $session->setFlashdata(
                    'error_saldo',
                    'Mohon maaf, saldo saat ini tidak mencukupi untuk pengajuan sebesar Rp ' .
                        number_format($nominal, 0, ',', '.')
                );
                return redirect()->to('/user/pengajuan');
            }

            // ✅ Simpan pengajuan baru
            $dataPengajuan = [
                'user_id'    => $session->get('id'),
                'nominal'    => $nominal,
                'keterangan' => $this->request->getVar('keterangan'),
                'deadline'   => $this->request->getVar('deadline'),
                'tipe'       => $this->request->getVar('tipe'),
                'status'     => 'pending'
            ];

            $pengajuanModel->save($dataPengajuan);
            $pengajuanId = $pengajuanModel->getInsertID();

            // ✅ Log pengajuan baru
            $logModel->logActivity(
                $session->get('id'),
                'pengajuan',
                'Membuat pengajuan baru sebesar Rp ' . number_format($nominal, 0, ',', '.')
            );

            // ✅ Jika tipe = uang_sendiri → otomatis simpan ke kas_keluar
            if ($this->request->getVar('tipe') === 'uang_sendiri') {
                $fileNota = $this->request->getFile('file_nota');
                $fileName = null;

                if ($fileNota && $fileNota->isValid() && !$fileNota->hasMoved()) {
                    $fileName = $fileNota->getRandomName();
                    $fileNota->move(FCPATH . 'uploads/nota', $fileName);
                }

                $kasKeluarModel->save([
                    'pengajuan_id' => $pengajuanId,
                    'nominal'      => $nominal,
                    'keterangan'   => $this->request->getVar('keterangan'),
                    'file_nota'    => $fileName
                ]);

                // ✅ Log kas keluar
                $logModel->logActivity(
                    $session->get('id'),
                    'kas_keluar',
                    'Menggunakan uang sendiri untuk pengajuan sebesar Rp ' . number_format($nominal, 0, ',', '.')
                );
            }

            return redirect()->to('/user/pengajuan')->with('success', 'Pengajuan berhasil dikirim.');
        } else {
            return view('user/pengajuan/create', [
                'validation' => $this->validator
            ]);
        }
    }
}
