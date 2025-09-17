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
        $data['kas_masuk'] = $model->findAll();
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
        $model = new KasMasukModel();
        $activityModel = new ActivityLogModel(); 

        $nominal = $this->request->getVar('nominal');
        $keterangan = $this->request->getVar('keterangan');

        $model->update($id, [
            'nominal' => $nominal,
            'keterangan' => $keterangan
        ]);

        // ✅ Simpan log aktivitas
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'update_kas_masuk',
            "Mengubah kas masuk ID {$id} menjadi Rp {$nominal} (keterangan: {$keterangan})"
        );

        return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new KasMasukModel();
        $activityModel = new ActivityLogModel();

        $data = $model->find($id); 
        $model->delete($id);

        // ✅ Simpan log aktivitas
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'delete_kas_masuk',
            "Menghapus kas masuk ID {$id} (nominal: Rp {$data['nominal']}, keterangan: {$data['keterangan']})"
        );

        return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil dihapus.');
    }
}
