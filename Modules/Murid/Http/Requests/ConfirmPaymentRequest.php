<?php

namespace Modules\Murid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'              => 'nullable|required_without:existing_file|mimes:jpg,jpeg,png,pdf|max:2048',
            'sender'            => 'required|string|max:255',
            'bank_sender'       => 'required|string|max:255',
            'destination_bank'  => 'required|string|max:255',
            'date_file'         => 'required|date|before_or_equal:today'
        ];
    }

    public function messages()
    {
        return [
            'file.required_without' => 'File Bukti Pembayaran tidak boleh kosong.',
            'file.mimes'            => 'File Bukti Pembayaran tidak valid.',
            'file.max'              => 'Ukuran bukti pembayaran maksimal 2 MB.',
            'sender.required'       => 'Nama Pengirim tidak boleh kosong.',
            'bank_sender.required'  => 'Bank Pengirim tidak boleh kosong.',
            'destination_bank.required' => 'Bank Tujuan tidak boleh kosong.',
            'date_file.required'    => 'Tanggal Transfer tidak boleh kosong.'
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
