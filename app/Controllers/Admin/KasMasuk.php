<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasSaldoModel;
use App\Models\ActivityLogModel;

class KasMasuk extends BaseController
{
    public function index()
    {
        $model = new KasMasukModel();

        $month = $this->request->getGet('month');
        $year  = $this->request->getGet('year');

        // Ambil data berdasarkan filter
        if ($month && $year) {
            $data['kas_masuk'] = $model
                ->where("MONTH(created_at)", $month)
                ->where("YEAR(created_at)", $year)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } elseif ($year) {
            $data['kas_masuk'] = $model
                ->where("YEAR(created_at)", $year)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } elseif ($month) {
            $data['kas_masuk'] = $model
                ->where("MONTH(created_at)", $month)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } else {
            $data['kas_masuk'] = $model
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        // 🟩 Hitung total kas berdasarkan hasil filter
        $totalKas = 0;
        if (!empty($data['kas_masuk'])) {
            foreach ($data['kas_masuk'] as $kas) {
                $totalKas += $kas['nominal'];
            }
        }
        $data['totalKas'] = $totalKas;

        return view('admin/kas_masuk/index', $data);
    }


    public function create()
    {
        helper(['form']);
        return view('admin/kas_masuk/create');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'nominal' => 'required|numeric',
            'keterangan' => 'required'
        ];
        
        if ($this->validate($rules)) {
            $kasMasukModel = new KasMasukModel();
            $kasSaldoModel = new KasSaldoModel();
            $activityModel = new ActivityLogModel(); 

            $nominal = $this->request->getVar('nominal');
            $keterangan = $this->request->getVar('keterangan');

            $kasMasukModel->save([
                'nominal' => $nominal,
                'keterangan' => $keterangan
            ]);
            
            // Update saldo
            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = $saldo['saldo_akhir'] + $nominal;
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            } else {
                $kasSaldoModel->save(['saldo_akhir' => $nominal]);
            }

            // ✅ Simpan ke activity log
            $session = session();
            $activityModel->logActivity(
                $session->get('id'),
                'menambah kas masuk',
                "Menambahkan kas masuk Rp {$nominal} (keterangan: {$keterangan})"
            );
            
            return redirect()->to('/admin/kas_masuk')->with('success', 'Kas masuk berhasil ditambahkan.');
        } else {
            return view('admin/kas_masuk/create', [
                'validation' => $this->validator
            ]);
        }
    }

    public function edit($id)
    {
        $model = new KasMasukModel();
        $data['kas'] = $model->find($id);

        if (!$data['kas']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data kas masuk dengan ID $id tidak ditemukan");
        }

        return view('admin/kas_masuk/edit', $data);
    }

    public function update($id)
    {
        $kasMasukModel = new KasMasukModel();
        $kasSaldoModel = new KasSaldoModel();
        $activityModel = new ActivityLogModel();

        $oldKas = $kasMasukModel->find($id);
        if (!$oldKas) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data kas masuk dengan ID $id tidak ditemukan");
        }

        $nominal = $this->request->getVar('nominal');
        $keterangan = $this->request->getVar('keterangan');

        $kasMasukModel->update($id, [
            'nominal' => $nominal,
            'keterangan' => $keterangan
        ]);

        // 🔄 Update saldo (kurangi nominal lama, tambah nominal baru)
        $saldo = $kasSaldoModel->first();
        if ($saldo) {
            $newSaldo = $saldo['saldo_akhir'] - $oldKas['nominal'] + $nominal;
            $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
        }

        // ✅ Simpan log aktivitas
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'update_kas_masuk',
            "Mengubah kas masuk ID {$id} dari Rp {$oldKas['nominal']} menjadi Rp {$nominal} (keterangan: {$keterangan})"
        );

        return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil diperbarui.');
    }


    public function delete($id)
    {
        $kasMasukModel = new KasMasukModel();
        $kasSaldoModel = new KasSaldoModel();
        $activityModel = new ActivityLogModel();

        // ambil data sebelum dihapus
        $data = $kasMasukModel->find($id);

        if ($data) {
            // hapus data kas masuk
            $kasMasukModel->delete($id);

            // update saldo otomatis
            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = max(0, $saldo['saldo_akhir'] - $data['nominal']);
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            }

            // log aktivitas
            $session = session();
            $activityModel->logActivity(
                $session->get('id'),
                'menghapus kas masuk',
                "Menghapus kas masuk ID {$id} (nominal: Rp {$data['nominal']}, keterangan: {$data['keterangan']})"
            );

            return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil dihapus dan saldo diperbarui.');
        }

        return redirect()->to('/admin/kas_masuk')->with('error', 'Data kas masuk tidak ditemukan.');
    }
}
