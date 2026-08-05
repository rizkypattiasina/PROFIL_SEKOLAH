<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Alamat tujuan setelah pengguna berhasil login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Daftarkan route aplikasi.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            /*
            |--------------------------------------------------------------------------
            | API Routes
            |--------------------------------------------------------------------------
            */

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            /*
            |--------------------------------------------------------------------------
            | Web Routes
            |--------------------------------------------------------------------------
            */

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Konfigurasi pembatasan permintaan API.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                optional($request->user())->id ?: $request->ip()
            );
        });
    }
}