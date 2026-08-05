<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\dataMurid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\PPDB\Entities\BerkasMurid;
use Modules\PPDB\Entities\DataOrangTua;
use Modules\SPP\Services\SppBillingService;

class DataMuridController extends Controller
{
    private $billing;

    public function __construct(SppBillingService $billing)
    {
        $this->billing = $billing;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        $allowed = ['Pendaftaran', 'Berkas', 'Murid', 'Ditolak'];

        $murid = User::with('muridDetail')
            ->whereHas('muridDetail', function ($query) use ($status, $allowed) {
                if (in_array($status, $allowed, true)) {
                    $query->where('proses', $status);
                }
            })
            ->whereIn('role', ['Guest', 'Murid'])
            ->latest()
            ->paginate(30)
            ->appends(['status' => $status]);

        return view('ppdb::backend.dataMurid.index', compact('murid', 'status', 'allowed'));
    }

    public function show($id)
    {
        $murid = User::with('muridDetail')->whereIn('role', ['Guest', 'Murid'])->findOrFail($id);
        DataOrangTua::firstOrCreate(['user_id' => $murid->id]);
        BerkasMurid::firstOrCreate(['user_id' => $murid->id]);
        $murid->load('dataOrtu', 'berkas');

        return view('ppdb::backend.dataMurid.show', compact('murid'));
    }

    public function update(Request $request, $id)
    {
        $murid = User::with('muridDetail', 'dataOrtu', 'berkas')
            ->whereIn('role', ['Guest', 'Murid'])
            ->findOrFail($id);

        $detailId = optional($murid->muridDetail)->id;
        $validated = $request->validate([
            'nis' => ['required', 'digits_between:4,18', Rule::unique('data_murids', 'nis')->ignore($detailId)],
            'nisn' => ['required', 'digits_between:8,18', Rule::unique('data_murids', 'nisn')->ignore($detailId)],
        ]);

        if (! optional($murid->muridDetail)->agama || ! optional($murid->dataOrtu)->nama_ayah || ! optional($murid->berkas)->kartu_keluarga) {
            return back()->withInput()->with('error', 'Calon murid belum melengkapi biodata, data orang tua, atau berkas.');
        }

        DB::transaction(function () use ($murid, $validated) {
            $murid->update(['role' => 'Murid', 'status' => 'Aktif']);
            $murid->muridDetail->nis = $validated['nis'];
            $murid->muridDetail->nisn = $validated['nisn'];
            $murid->muridDetail->proses = 'Murid';
            $murid->muridDetail->save();
            $murid->syncRoles(['Murid']);
            $this->billing->ensureForStudent($murid, (int) date('Y'));
        });

        return redirect()->route('data-murid.index', ['status' => 'Murid'])
            ->with('success', 'Calon murid diterima dan tagihan SPP berhasil dibuat.');
    }

    public function reject($id)
    {
        $murid = User::with('muridDetail')->where('role', 'Guest')->findOrFail($id);
        $murid->muridDetail->proses = 'Ditolak';
        $murid->muridDetail->save();

        return redirect()->route('data-murid.index', ['status' => 'Ditolak'])
            ->with('success', 'Pendaftaran calon murid ditandai ditolak.');
    }
}
