<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class VideoController extends Controller
{
    /**
     * Menampilkan seluruh data video.
     */
    public function index(): View
    {
        $video = Video::latest()->get();

        return view(
            'backend.website.content.video.index',
            compact('video')
        );
    }

    /**
     * Menampilkan form tambah video.
     *
     * Jika form tambah berada di halaman index,
     * method ini boleh tetap mengarah ke index.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('backend-video.index');
    }

    /**
     * Menyimpan video baru.
     */
    public function store(VideoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                /*
                 * Berdasarkan kode lama:
                 * nilai 0 dianggap sebagai video yang sedang aktif.
                 *
                 * Jika video baru dibuat aktif, video aktif lain
                 * diubah menjadi tidak aktif.
                 */
                if ((string) $validated['is_active'] === '0') {
                    Video::where('is_active', '0')
                        ->update([
                            'is_active' => '1',
                        ]);
                }

                Video::create([
                    'title' => $validated['title'],
                    'desc' => $validated['desc'],
                    'url' => $validated['url'],
                    'is_active' => $validated['is_active'],
                ]);
            });

            return redirect()
                ->route('backend-video.index')
                ->with('success', 'Video berhasil ditambahkan.');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Video gagal ditambahkan. Silakan coba kembali.');
        }
    }

    /**
     * Menampilkan detail video.
     */
    public function show(int $id): RedirectResponse
    {
        return redirect()->route('backend-video.index');
    }

    /**
     * Menampilkan form edit video.
     */
    public function edit(int $id): View
    {
        $video = Video::findOrFail($id);

        return view(
            'backend.website.content.video.edit',
            compact('video')
        );
    }

    /**
     * Memperbarui data video.
     */
    public function update(VideoRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated, $id) {
                $video = Video::findOrFail($id);

                /*
                 * Jika video ini diaktifkan, nonaktifkan video aktif lain.
                 * Video yang sedang diperbarui dikecualikan.
                 */
                if ((string) $validated['is_active'] === '0') {
                    Video::where('id', '!=', $video->id)
                        ->where('is_active', '0')
                        ->update([
                            'is_active' => '1',
                        ]);
                }

                $video->update([
                    'title' => $validated['title'],
                    'desc' => $validated['desc'],
                    'url' => $validated['url'],
                    'is_active' => $validated['is_active'],
                ]);
            });

            return redirect()
                ->route('backend-video.index')
                ->with('success', 'Video berhasil diperbarui.');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Video gagal diperbarui. Silakan coba kembali.');
        }
    }

    /**
     * Menghapus video.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return redirect()
                ->route('backend-video.index')
                ->with('success', 'Video berhasil dihapus.');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Video gagal dihapus.');
        }
    }
}