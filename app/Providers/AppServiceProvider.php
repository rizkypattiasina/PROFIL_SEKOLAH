<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Footer;
use App\Models\Jurusan;
use App\Models\Kegiatan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['frontend.content.footer'],
            function ($view) {
                $view->with('footer', $view->getData()['footer'] ?? Footer::first());
                $view->with(
                    'footerNews',
                    Berita::where('is_active', '0')
                        ->whereNotNull('thumbnail')
                        ->latest()
                        ->take(6)
                        ->get()
                );
                $view->with(
                    'footerPrograms',
                    Jurusan::where('is_active', '0')->orderBy('nama')->take(4)->get()
                );
                $view->with(
                    'footerActivities',
                    Kegiatan::where('is_active', '0')->orderBy('nama')->take(4)->get()
                );
            }
        );
    }
}
