<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Berita;
use App\Models\Events;
use App\Models\Footer;
use App\Models\ImageSlider;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\KategoriBerita;
use App\Models\Kegiatan;
use App\Models\ProfileSekolah;
use App\Models\User;
use App\Models\Video;
use App\Models\Visimisi;

class IndexController extends Controller
{
    //Welcome
    public function index()
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Gambar Slider
        $slider = ImageSlider::where('is_Active','0')->get();

        // About
        $about = About::where('is_Active','0')->first();

        // Video
        $videos = Video::where('is_active','0')->orderBy('created_at','desc')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Berita
        $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->take(6)->get();

        // Event
        $event = Events::where('is_active','0')
            ->where('acara', '>=', now()->startOfDay())
            ->orderBy('acara')
            ->take(4)
            ->get();

        // Footer
        $footer = Footer::first();

        return view('frontend.welcome', compact('jurusanM','kegiatanM','slider','about','videos','pengajar','berita','event','footer'));
    }

    // Berita
    public function berita(Request $request)
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Kategori
         $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();
         
         // Berita
         $search = trim((string) $request->query('q'));
         $berita = Berita::where('is_active','0')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($news) use ($search) {
                    $news->where('title', 'like', '%'.$search.'%')
                        ->orWhere('desc', 'like', '%'.$search.'%')
                        ->orWhere('content', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('created_at','desc')
            ->paginate(10)
            ->appends(['q' => $search]);
 
         return view('frontend.content.beritaAll', compact('berita','kategori','jurusanM','kegiatanM','footer','search'));
    }
    // Show Detail Berita
    public function detailBerita($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Footer
        $footer = Footer::first();

        // Kategori
        $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();
        
        // Berita
        $beritaOther = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

        $berita = Berita::where('slug',$slug)->first();
        return view('frontend.content.showBerita', compact('berita','kategori','beritaOther','jurusanM','kegiatanM','footer'));
    }


    // Events
    public function events()
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();
 
         $event = Events::where('is_active','0')->orderBy('created_at','desc')->get();
         return view('frontend.content.event.eventAll', compact('event','berita','jurusanM','kegiatanM','footer'));
    }


    // Detail Event
    public function detailEvent($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();
 
         $event = Events::where('slug',$slug)->first();
         $eventOther = Events::where('is_active','0')->orderBy('created_at','desc')->get();

         return view('frontend.content.event.detailEvent', compact('event','eventOther','berita','jurusanM','kegiatanM','footer'));
    }

    // Profile Sekolah
    public function profileSekolah()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $profile = ProfileSekolah::first();
        return view('frontend.content.profileSekolah', compact('profile','jurusanM','kegiatanM','pengajar','footer'));
    }

    // Visi dan Misi
    public function visimisi()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $visimisi = Visimisi::first();
        return view('frontend.content.visimisi', compact('visimisi','jurusanM','kegiatanM','pengajar','footer'));
    }

    public function alumni()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();
        $footer = Footer::first();
        $alumni = User::with('muridDetail')->where('role','Alumni')->where('status','Aktif')->orderBy('name')->paginate(24);
        return view('frontend.content.alumni', compact('alumni','jurusanM','kegiatanM','footer'));
    }

}
