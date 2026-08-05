<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\dataMurid;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\PPDB\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registerView()
    {
        return view('ppdb::auth.register');
    }

    public function registerStore(RegisterRequest $request)
    {
        DB::transaction(function () use ($request) {
            $register = User::create([
                'name' => trim($request->name),
                'username' => $this->uniqueUsername($request->name),
                'email' => strtolower(trim($request->email)),
                'role' => 'Guest',
                'status' => 'Aktif',
                'password' => bcrypt($request->password),
            ]);

            $detail = new dataMurid();
            $detail->user_id = $register->id;
            $detail->whatsapp = $request->whatsapp;
            $detail->asal_sekolah = $request->asal_sekolah;
            $detail->proses = 'Pendaftaran';
            $detail->save();

            $register->syncRoles(['Guest']);
        });

        return redirect()->route('login')
            ->with('success', 'Akun PPDB berhasil dibuat. Silakan masuk untuk melengkapi pendaftaran.');
    }

    private function uniqueUsername(string $name): string
    {
        $base = Str::slug(Str::before(trim($name), ' '), '');
        $base = $base ?: 'pendaftar';
        $candidate = $base;
        $number = 1;

        while (User::where('username', $candidate)->exists()) {
            $candidate = $base.$number;
            $number++;
        }

        return $candidate;
    }
}
