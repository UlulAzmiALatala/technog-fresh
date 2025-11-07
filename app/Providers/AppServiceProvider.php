<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\AdminLayoutComposer;
use App\Http\View\Composers\PublicLayoutComposer;

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
        View::composer('components.admin-layout', AdminLayoutComposer::class);
        View::composer('components.public', PublicLayoutComposer::class);
    }
}
