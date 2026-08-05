<?php

namespace Modules\PPDB\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\PPDB\Entities\PpdbContent;

class PpdbContentController extends Controller
{
    public const SECTIONS = [
        'program' => 'Program',
        'alur' => 'Alur',
        'berkas' => 'Berkas',
        'informasi' => 'Informasi',
    ];

    public function index(Request $request)
    {
        $section = $request->query('section');
        $contents = PpdbContent::when(array_key_exists($section, self::SECTIONS), function ($query) use ($section) {
                $query->where('section', $section);
            })
            ->orderBy('section')
            ->orderBy('sort_order')
            ->paginate(30)
            ->appends(['section' => $section]);

        $sections = self::SECTIONS;

        return view('ppdb::backend.content.index', compact('contents', 'sections', 'section'));
    }

    public function create(Request $request)
    {
        $content = new PpdbContent([
            'section' => array_key_exists($request->query('section'), self::SECTIONS) ? $request->query('section') : 'program',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $sections = self::SECTIONS;

        return view('ppdb::backend.content.form', compact('content', 'sections'));
    }

    public function store(Request $request)
    {
        PpdbContent::create($this->validated($request));

        return redirect()->route('ppdb-content.index', ['section' => $request->section])
            ->with('success', 'Konten PPDB berhasil ditambahkan.');
    }

    public function edit(PpdbContent $ppdb_content)
    {
        $content = $ppdb_content;
        $sections = self::SECTIONS;

        return view('ppdb::backend.content.form', compact('content', 'sections'));
    }

    public function update(Request $request, PpdbContent $ppdb_content)
    {
        $ppdb_content->update($this->validated($request));

        return redirect()->route('ppdb-content.index', ['section' => $request->section])
            ->with('success', 'Konten PPDB berhasil diperbarui.');
    }

    public function destroy(PpdbContent $ppdb_content)
    {
        $section = $ppdb_content->section;
        $ppdb_content->delete();

        return redirect()->route('ppdb-content.index', ['section' => $section])
            ->with('success', 'Konten PPDB berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'section' => ['required', Rule::in(array_keys(self::SECTIONS))],
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:5000',
            'icon' => 'nullable|string|max:50|regex:/^[a-z0-9-]+$/',
            'sort_order' => 'required|integer|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['icon'] = $data['icon'] ?: 'check-circle';

        return $data;
    }
}
