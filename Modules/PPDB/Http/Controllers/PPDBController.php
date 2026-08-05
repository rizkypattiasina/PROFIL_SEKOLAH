<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\Footer;
use App\Models\Video;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PPDB\Entities\PpdbContent;

class PPDBController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $footer = Footer::first();
        $ppdbContents = PpdbContent::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('section');
        $ppdbVideo = Video::where('is_active', '0')
            ->whereNotNull('url')
            ->latest()
            ->first();

        return view('ppdb::index', compact('footer', 'ppdbContents', 'ppdbVideo'));
    }

    
}
