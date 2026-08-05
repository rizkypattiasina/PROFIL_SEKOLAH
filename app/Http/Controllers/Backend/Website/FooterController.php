<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Requests\FooterRequest;
use ErrorException;
use Session;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footer = Footer::first();
        return view('backend.website.content.footer.index',compact('footer'));
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
    public function store(FooterRequest $request)
    {
        try {
            $data = $request->safe()->except(['logo','favicon']);
            foreach (['facebook','instagram','twitter','youtube','telp','whatsapp','email','desc'] as $field) {
                $data[$field] = $data[$field] ?? '';
            }
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('images/logo', 'public');
            }
            if ($request->hasFile('favicon')) {
                $data['favicon'] = $request->file('favicon')->store('images/favicon', 'public');
            }
            Footer::create($data);

            Session::flash('success','Data Berhasil dibuat !');
            return redirect()->route('backend-footer.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
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
    public function update(FooterRequest $request, $id)
    {
        try {
            $footer = Footer::findOrFail($id);
            $data = $request->safe()->except(['logo','favicon']);
            foreach (['facebook','instagram','twitter','youtube','telp','whatsapp','email','desc'] as $field) {
                $data[$field] = $data[$field] ?? '';
            }
            foreach (['logo' => 'images/logo', 'favicon' => 'images/favicon'] as $field => $folder) {
                if ($request->hasFile($field)) {
                    if ($footer->{$field}) Storage::disk('public')->delete($footer->{$field});
                    $data[$field] = $request->file($field)->store($folder, 'public');
                }
            }
            $footer->update($data);

            Session::flash('success','Data Berhasil diupdate !');
            return redirect()->route('backend-footer.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
