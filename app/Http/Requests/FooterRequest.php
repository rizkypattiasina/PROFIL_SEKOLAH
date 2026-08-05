<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FooterRequest extends FormRequest
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
        $logo = $this->isMethod('post') ? 'required' : 'nullable';
        $platformUrl = function (array $domains) {
            return function ($attribute, $value, $fail) use ($domains) {
                if (empty($value)) {
                    return;
                }

                $scheme = strtolower((string) parse_url($value, PHP_URL_SCHEME));
                $host = strtolower((string) parse_url($value, PHP_URL_HOST));
                $validDomain = collect($domains)->contains(function ($domain) use ($host) {
                    return $host === $domain || Str::endsWith($host, '.'.$domain);
                });

                if (!in_array($scheme, ['http', 'https'], true) || !$validDomain) {
                    $fail('Alamat pada '.$attribute.' harus menggunakan tautan resmi '.implode(' atau ', $domains).'.');
                }
            };
        };
        $contentUrl = function ($pattern, $message) {
            return function ($attribute, $value, $fail) use ($pattern, $message) {
                if (!empty($value) && !preg_match($pattern, $value)) {
                    $fail($message);
                }
            };
        };

        return [
            'school_name' => 'required|string|max:120', 'tagline' => 'nullable|string|max:180',
            'address' => 'nullable|string|max:500',
            'primary_color' => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo' => $logo.'|image|mimes:png,jpg,jpeg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg,webp|max:1024',
            'email' => 'nullable|email|max:120', 'telp' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30', 'desc' => 'nullable|string|max:1000',
            'facebook' => ['nullable','url','max:255',$platformUrl(['facebook.com','fb.com'])],
            'instagram' => ['nullable','url','max:255',$platformUrl(['instagram.com'])],
            'tiktok' => ['nullable','url','max:255',$platformUrl(['tiktok.com'])],
            'twitter' => ['nullable','url','max:255',$platformUrl(['twitter.com','x.com'])],
            'youtube' => ['nullable','url','max:255',$platformUrl(['youtube.com','youtu.be'])],
            'linkedin' => ['nullable','url','max:255',$platformUrl(['linkedin.com'])],
            'instagram_handle' => 'nullable|string|max:80',
            'tiktok_handle' => 'nullable|string|max:80',
            'youtube_handle' => 'nullable|string|max:80',
            'instagram_embed_url' => ['nullable','url','max:500',$platformUrl(['instagram.com']),$contentUrl('#instagram\.com/(?:p|reel|tv)/[A-Za-z0-9_-]+#i', 'URL feed Instagram harus berupa tautan Post atau Reel publik.')],
            'tiktok_embed_url' => ['nullable','url','max:500',$platformUrl(['tiktok.com']),$contentUrl('#tiktok\.com/@[^/]+/video/[0-9]+#i', 'URL feed TikTok harus berupa tautan video lengkap, bukan tautan pendek.')],
            'youtube_embed_url' => ['nullable','url','max:500',$platformUrl(['youtube.com','youtu.be']),$contentUrl('#(?:youtu\.be/|youtube\.com/(?:watch\?.*v=|embed/|shorts/|live/))[A-Za-z0-9_-]{6,}#i', 'URL feed YouTube harus berupa tautan video, Shorts, atau Live yang valid.')],
        ];
    }

    public function messages()
    {
        return [
            'youtube.required'      => 'Akun Youtube tidak boleh kosong.',
            'instagram.required'    => 'Akun Instagram tidak boleh kosong',
            'twitter.required'      => 'Akun Twitter tidak boleh kosong',
            'facebook.required'     => 'Akun Youtube Facebook boleh kosong',
            'logo.required'         => 'Logo Sekolah tidak boleh kosong',
            'logo.image'            => 'File Logo yang dimasukan tidak valid.',
            'logo.max'              => 'Maksimal File Logo tidak boleh lebih dari 1MB.',
            'whatsapp.required'     => 'Nomor WhatsApp tidak boleh kosong',
            'whatsapp.numeric'      => 'Nomor WhatsApp hanya mendukung number.',
            'telp.required'         => 'Nomor Telepon tidak boleh kosong',
            'telp.numeric'          => 'Nomor Telepon hanya mendukun number.',
            'email.required'        => 'Email tidak boleh kosong',
            'email.email'           => 'Email yang dimasukan tidak valid.',
            'desc.required'         => 'Deskripsi Sekolah tidak boleh kosong',
        ];
    }
}
