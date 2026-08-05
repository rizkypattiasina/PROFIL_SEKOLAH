<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $alumni = User::with('muridDetail')->where('role','Alumni')
            ->when($keyword, fn($q) => $q->where(fn($x) => $x->where('name','like',"%{$keyword}%")->orWhere('email','like',"%{$keyword}%")))
            ->orderBy('name')->paginate(20);
        $murid = User::where('role','Murid')->where('status','Aktif')->orderBy('name')->get();
        return view('backend.pengguna.alumni.index', compact('alumni','murid'));
    }

    public function store(User $user)
    {
        abort_unless(in_array($user->role, ['Murid','Alumni']), 422);
        $user->syncRoles(['Alumni']);
        $user->update(['role' => 'Alumni', 'status' => 'Aktif']);
        return back()->with('success', $user->name.' berhasil dipindahkan ke data alumni.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->role === 'Alumni', 422);
        $user->syncRoles(['Murid']);
        $user->update(['role' => 'Murid']);
        return back()->with('success', $user->name.' dikembalikan menjadi murid aktif.');
    }
}
