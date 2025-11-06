<?php

namespace App\Http\View\Composers; // <-- PERHATIKAN NAMESPACE YANG BENAR

use App\Models\Logo;
use App\Models\SocialLink;
use Illuminate\View\View;

class PublicLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // 1. Ambil Logo untuk Footer
        $footerLogo = Logo::where('name', 'Footer Light')
            ->where('is_active', true)
            ->first();

        // 2. Ambil Semua Social Links
        $socialLinks = SocialLink::orderBy('sort_order', 'asc')->get();

        // 3. Kirim data ke view
        $view->with('footerLogo', $footerLogo)
            ->with('socialLinks', $socialLinks);
    }
}
