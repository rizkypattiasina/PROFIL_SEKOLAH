<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileSettingsRequest;
use App\Http\Requests\ChangePasswordRequest;
use ErrorException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = User::whereId(Auth::id())->first();
        return view('backend.profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileSettingsRequest $request, $id)
    {
        abort_unless((int) $id === (int) Auth::id(), 403);

        try {
            if ($request->foto_profile) {
                $image = $request->file('foto_profile');
                $storedImage = $image->store('images/profile', 'public');
                $nama_image = basename($storedImage);
            }

            $profile = Auth::user();
            if (! empty($nama_image) && $profile->foto_profile) {
                Storage::disk('public')->delete('images/profile/'.$profile->foto_profile);
            }
            $emailChanged = $profile->email !== $request->email;
            $profile->name          = $request->name;
            $profile->username      = $request->username;
            $profile->email         = $request->email;
            $profile->foto_profile  = $nama_image ?? $profile->foto_profile;
            if ($emailChanged) {
                $profile->email_verified_at  = NULL;
            }
            $profile->save();

            Session::flash('success','Profile Berhasil diupdate !');
            return back();

        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    // Ubah Password
    public function changePassword(ChangePasswordRequest $request, $id)
    {
       abort_unless((int) $id === (int) Auth::id(), 403);

       try {
            $profile = Auth::user();
            $profile->password   = bcrypt($request->password);
            $profile->save();

            Session::flash('success','Password Berhasil diudate !');
            return back();

       } catch (ErrorException $e) {
           throw new ErrorException($e->getMessage());
       }
    }
}
