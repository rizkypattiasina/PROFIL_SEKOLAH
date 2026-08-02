<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita.
     */
    public function index()
    {
        $kategori = KategoriBerita::where('is_Active', '0')->get();
        $berita = Berita::all();

        return view(
            'backend.website.content.berita.index',
            compact('kategori', 'berita')
        );
    }

    /**
     * Menampilkan form tambah berita.
     */
    public function create()
    {
        $kategori = KategoriBerita::where('is_Active', '0')->get();

        return view(
            'backend.website.content.berita.create',
            compact('kategori')
        );
    }

    /**
     * Menyimpan berita baru.
     */
    public function store(BeritaRequest $request)
    {
        try {
            $namaImage = null;

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');

                $namaImage = now()->format('YmdHis')
                    . '_'
                    . Str::random(10)
                    . '.'
                    . $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/images/berita',
                    $namaImage
                );
            }

            $slug = Str::slug($request->title);

            /*
             * Mencegah slug sama jika ada judul berita yang sama.
             */
            $slugAsli = $slug;
            $nomor = 1;

            while (Berita::where('slug', $slug)->exists()) {
                $slug = $slugAsli . '-' . $nomor;
                $nomor++;
            }

            $berita = new Berita();
            $berita->title = $request->title;
            $berita->slug = $slug;
            $berita->content = $request->content;
            $berita->kategori_id = $request->kategori_id;
            $berita->thumbnail = $namaImage;
            $berita->created_by = Auth::id();
            $berita->is_active = '0';
            $berita->save();

            Session::flash(
                'success',
                'Berita berhasil ditambahkan.'
            );

            return redirect()->route('backend-berita.index');
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Berita gagal ditambahkan: ' . $e->getMessage()
                );
        }
    }

    /**
     * Menampilkan detail berita pada backend.
     */
    public function show($id)
    {
        //
    }

    /**
     * Menampilkan form edit berita.
     */
    public function edit($id)
    {
        $kategori = KategoriBerita::where('is_Active', '0')->get();

        $berita = Berita::findOrFail($id);

        return view(
            'backend.website.content.berita.edit',
            compact('kategori', 'berita')
        );
    }

    /**
     * Memperbarui berita.
     */
    public function update(BeritaRequest $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            $namaImage = $berita->thumbnail;

            if ($request->hasFile('thumbnail')) {
                /*
                 * Hapus thumbnail lama jika tersedia.
                 */
                if (
                    $berita->thumbnail &&
                    Storage::exists(
                        'public/images/berita/' . $berita->thumbnail
                    )
                ) {
                    Storage::delete(
                        'public/images/berita/' . $berita->thumbnail
                    );
                }

                $image = $request->file('thumbnail');

                $namaImage = now()->format('YmdHis')
                    . '_'
                    . Str::random(10)
                    . '.'
                    . $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/images/berita',
                    $namaImage
                );
            }

            /*
             * Buat ulang slug jika judul berubah.
             */
            $slug = Str::slug($request->title);
            $slugAsli = $slug;
            $nomor = 1;

            while (
                Berita::where('slug', $slug)
                    ->where('id', '!=', $berita->id)
                    ->exists()
            ) {
                $slug = $slugAsli . '-' . $nomor;
                $nomor++;
            }

            $berita->title = $request->title;
            $berita->slug = $slug;
            $berita->content = $request->content;
            $berita->kategori_id = $request->kategori_id;
            $berita->thumbnail = $namaImage;
            $berita->is_active = $request->is_active ?? $berita->is_active;
            $berita->save();

            Session::flash(
                'success',
                'Berita berhasil diperbarui.'
            );

            return redirect()->route('backend-berita.index');
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Berita gagal diperbarui: ' . $e->getMessage()
                );
        }
    }

    /**
     * Upload gambar dari Summernote ke dalam isi berita.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'image.required' => 'Silakan pilih gambar.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        try {
            $image = $request->file('image');

            $namaImage = now()->format('YmdHis')
                . '_'
                . Str::random(12)
                . '.'
                . $image->getClientOriginalExtension();

            $path = $image->storeAs(
                'berita/content',
                $namaImage,
                'public'
            );

            return response()->json([
                'success' => true,

                /*
                 * Cocok untuk project yang dijalankan melalui:
                 * http://localhost/sekolahku/public
                 */
                'url' => asset('storage/' . $path),

                'path' => $path,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gambar gagal diunggah.',
            ], 500);
        }
    }

    /**
     * Menghapus gambar konten yang dihapus dari Summernote.
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'image_url' => [
                'required',
                'string',
            ],
        ]);

        try {
            $imageUrl = $request->input('image_url');
            $urlPath = parse_url($imageUrl, PHP_URL_PATH);

            if (!$urlPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat gambar tidak valid.',
                ], 422);
            }

            $storagePosition = strpos($urlPath, '/storage/');

            if ($storagePosition === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gambar bukan berasal dari storage aplikasi.',
                ], 422);
            }

            $relativePath = substr(
                $urlPath,
                $storagePosition + strlen('/storage/')
            );

            $relativePath = urldecode($relativePath);

            /*
             * Batasi agar hanya gambar isi berita yang bisa dihapus.
             */
            if (!Str::startsWith($relativePath, 'berita/content/')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi gambar tidak diizinkan.',
                ], 403);
            }

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus.',
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gambar gagal dihapus.',
            ], 500);
        }
    }

    /**
     * Menghapus berita.
     */
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            if (
                $berita->thumbnail &&
                Storage::exists(
                    'public/images/berita/' . $berita->thumbnail
                )
            ) {
                Storage::delete(
                    'public/images/berita/' . $berita->thumbnail
                );
            }

            /*
             * Catatan:
             * Gambar di dalam content belum otomatis dihapus di sini.
             */
            $berita->delete();

            return redirect()
                ->route('backend-berita.index')
                ->with('success', 'Berita berhasil dihapus.');
        } catch (Throwable $e) {
            report($e);

            return back()->with(
                'error',
                'Berita gagal dihapus: ' . $e->getMessage()
            );
        }
    }
}