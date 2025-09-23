<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View; // <-- IMPORT BARU
use App\Http\View\Composers\AdminLayoutComposer; // <-- IMPORT BARU

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Daftarkan alias middleware secara manual
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);

        // --- TAMBAHKAN BARIS INI ---
        // Daftarkan View Composer untuk layout admin agar bisa mengambil notifikasi
        View::composer('components.admin-layout', AdminLayoutComposer::class);
    }
}
