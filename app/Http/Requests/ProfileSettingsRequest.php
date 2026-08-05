<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'email'         => ['required','email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'foto_profile'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024']
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama tidak boleh kosong.',
            'username.required'     => 'Username tidak boleh kosong.',
            'email.required'        => 'Email tidak boleh kosong.',
            'email.email'           => 'Email yang dimasukan tidak valid.',
            'foto_profile.image'    => 'Foto Profile yang dimasukan tidak valid.',
            'foto_profile.max'      => 'Maksimal ukuran Foto Profile 1MB.'
        ];
    }
}
