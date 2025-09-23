<?php
// Lokasi: app/Http/View/Composers/AdminLayoutComposer.php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (Auth::check()) {
            $notifications = Auth::user()->unreadNotifications;
            $view->with('unreadNotifications', $notifications);
        }
    }
}
