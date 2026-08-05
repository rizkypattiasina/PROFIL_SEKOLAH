<?php

namespace Modules\PPDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\PPDB\Entities\BerkasMurid;

class BerkasMuridRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $existing = BerkasMurid::where('user_id', Auth::id())->first();
        $required = function ($field) use ($existing) {
            return $existing && $existing->{$field} ? 'nullable' : 'required';
        };

        return [
          'kartu_keluarga'          => $required('kartu_keluarga').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'akte_kelahiran'          => $required('akte_kelahiran').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'surat_kelakuan_baik'     => $required('surat_kelakuan_baik').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'surat_sehat'             => $required('surat_sehat').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'surat_tidak_buta_warna'  => $required('surat_tidak_buta_warna').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'rapor'                   => $required('rapor').'|mimes:jpg,jpeg,png,pdf|max:2048',
          'foto'                    => $required('foto').'|mimes:jpg,jpeg,png|max:2048',
          'ijazah'                  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ];
    }

    public function messages()
    {
      return [
        'kartu_keluarga.required'         => 'File Kartu Keluarga tidak boleh kosong.',
        'kartu_keluarga.mimes'            => 'Kartu Keluarga hanya mendukung .jpg .jpeg .png atau pdf.',
        'kartu_keluarga.max'              => 'Ukuran file tidak boleh lebih dari 2MB.',
        'akte_kelahiran.required'         => 'File Akte Kelahiran tidak boleh kosong.',
        'akte_kelahiran.mimes'            => 'Akte Kelahiran hanya mendukung .jpg .jpeg .png atau pdf.',
        'akte_kelahiran.max'              => 'Ukuran file tidak boleh lebih dari 2MB.',
        'surat_kelakuan_baik.required'    => 'Surat Kelakuan Baik tidak boleh kosong.',
        'surat_kelakuan_baik.mimes'       => 'Surat Kelakuan Baik hanya mendukung .jpg .jpeg .png atau pdf.',
        'surat_kelakuan_baik.max'         => 'Ukuran file tidak boleh lebih dari 2MB.',
        'surat_sehat.required'            => 'Surat Sehat tidak boleh kosong.',
        'surat_sehat.mimes'               => 'Surat Sehat hanya mendukung .jpg .jpeg .png atau pdf.',
        'surat_sehat.max'                 => 'Ukuran file tidak boleh lebih dari 2MB.',
        'surat_tidak_buta_warna.required' => 'Surat Tidak Buta Warna tidak boleh kosong.',
        'surat_tidak_buta_warna.mimes'    => 'Surat Tidak Buta Warna hanya mendukung .jpg .jpeg .png atau pdf.',
        'surat_tidak_buta_warna.max'      => 'Ukuran file tidak boleh lebih dari 2MB.',
        'rapor.required'                  => 'Rapor tidak boleh kosong.',
        'rapor.mimes'                     => 'Rapor hanya mendukung .jpg .jpeg .png atau pdf.',
        'rapor.max'                       => 'Ukuran file tidak boleh lebih dari 2MB.',
        'foto.required'                   => 'Foto tidak boleh kosong.',
        'foto.mimes'                      => 'Foto hanya mendukung .jpg .jpeg .png atau pdf.',
        'foto.max'                        => 'Ukuran file tidak boleh lebih dari 2MB.',
        'ijazah.mimes'                    => 'File Ijazah hanya mendukung .jpg .jpeg .png atau pdf.',
        'ijazah.max'                      => 'Ukuran file tidak boleh lebih dari 2MB.',
      ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
