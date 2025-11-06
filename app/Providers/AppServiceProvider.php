<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\AdminLayoutComposer;
use App\Http\View\Composers\PublicLayoutComposer; // <-- 1. TAMBAHKAN INI (dengan path 'Http')

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
        // Daftarkan alias middleware (Sudah benar)
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);

        // Daftarkan View Composer untuk layout admin (Sudah benar)
        View::composer('components.admin-layout', AdminLayoutComposer::class);

        // --- 2. TAMBAHKAN BARIS INI ---
        // Daftarkan View Composer untuk footer publik
        View::composer('layouts.public-footer', PublicLayoutComposer::class);
        // --- AKHIR TAMBAHAN ---
    }
}
