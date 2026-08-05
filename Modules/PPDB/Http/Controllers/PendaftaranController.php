<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\dataMurid;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\PPDB\Entities\BerkasMurid;
use Modules\PPDB\Entities\DataOrangTua;
use Modules\PPDB\Http\Requests\BerkasMuridRequest;
use Modules\PPDB\Http\Requests\DataMuridRequest;
use Modules\PPDB\Http\Requests\DataOrtuRequest;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('muridDetail');

        if (! $user->muridDetail) {
            $detail = new dataMurid();
            $detail->user_id = $user->id;
            $detail->proses = 'Pendaftaran';
            $detail->save();
            $user->load('muridDetail');
        }

        return view('ppdb::backend.pendaftaran.index', compact('user'));
    }

    public function update(DataMuridRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
            ]);

            $murid = dataMurid::where('user_id', $user->id)->firstOrFail();
            $murid->tempat_lahir = $request->tempat_lahir;
            $murid->tgl_lahir = $request->tgl_lahir;
            $murid->agama = $request->agama;
            $murid->telp = $request->telp;
            $murid->whatsapp = $request->whatsapp;
            $murid->alamat = $request->alamat;
            $murid->asal_sekolah = $request->asal_sekolah;
            $murid->proses = 'Pendaftaran';
            $murid->save();

            DataOrangTua::firstOrCreate(['user_id' => $user->id]);
        });

        return redirect()->route('ppdb.form-orangtua')
            ->with('success', 'Biodata calon murid berhasil disimpan.');
    }

    public function dataOrtuView()
    {
        $murid = dataMurid::where('user_id', Auth::id())->first();
        if (! $murid || ! $murid->agama) {
            return redirect()->route('ppdb.form-pendaftaran')
                ->with('error', 'Lengkapi biodata calon murid terlebih dahulu.');
        }

        $ortu = DataOrangTua::firstOrCreate(['user_id' => Auth::id()]);

        return view('ppdb::backend.pendaftaran.dataOrtu', compact('ortu'));
    }

    public function updateOrtu(DataOrtuRequest $request)
    {
        $ortu = DataOrangTua::firstOrCreate(['user_id' => Auth::id()]);
        $ortu->nama_ayah = $request->nama_ayah;
        $ortu->pekerjaan_ayah = $request->pekerjaan_ayah;
        $ortu->pendidikan_ayah = $request->pendidikan_ayah;
        $ortu->telp_ayah = $request->telp_ayah;
        $ortu->alamat_ayah = $request->alamat_ayah;
        $ortu->nama_ibu = $request->nama_ibu;
        $ortu->pekerjaan_ibu = $request->pekerjaan_ibu;
        $ortu->pendidikan_ibu = $request->pendidikan_ibu;
        $ortu->telp_ibu = $request->telp_ibu;
        $ortu->alamat_ibu = $request->alamat_ibu;
        $ortu->save();

        BerkasMurid::firstOrCreate(['user_id' => Auth::id()]);

        return redirect()->route('ppdb.form-berkas')
            ->with('success', 'Data orang tua berhasil disimpan.');
    }

    public function berkasView()
    {
        $ortu = DataOrangTua::where('user_id', Auth::id())->first();
        if (! $ortu || ! $ortu->nama_ayah || ! $ortu->nama_ibu) {
            return redirect()->route('ppdb.form-orangtua')
                ->with('error', 'Lengkapi data orang tua terlebih dahulu.');
        }

        $berkas = BerkasMurid::firstOrCreate(['user_id' => Auth::id()]);

        return view('ppdb::backend.pendaftaran.berkas', compact('berkas'));
    }

    public function berkasStore(BerkasMuridRequest $request)
    {
        $berkas = BerkasMurid::where('user_id', Auth::id())->firstOrFail();
        $fields = [
            'kartu_keluarga', 'akte_kelahiran', 'surat_kelakuan_baik',
            'surat_sehat', 'surat_tidak_buta_warna', 'rapor', 'foto', 'ijazah',
        ];

        foreach ($fields as $field) {
            if (! $request->hasFile($field)) {
                continue;
            }

            if ($berkas->{$field}) {
                Storage::disk('public')->delete('images/berkas_murid/'.$berkas->{$field});
            }

            $stored = $request->file($field)->store('images/berkas_murid', 'public');
            $berkas->{$field} = basename($stored);
        }

        $berkas->save();

        dataMurid::where('user_id', Auth::id())->update(['proses' => 'Berkas']);

        return redirect()->route('home')
            ->with('success', 'Berkas berhasil dikirim dan menunggu verifikasi petugas PPDB.');
    }
}
