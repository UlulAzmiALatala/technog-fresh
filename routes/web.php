<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Controller Publik ---
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ContactController; // <-- Pastikan ini sudah diimport
use App\Http\Controllers\Midtrans\NotificationController;

// --- Controller Klien ---
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Client\ServiceListController;

// --- Controller Admin (Struktur Baru) ---
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Founder\CaseStudyController;
use App\Http\Controllers\Admin\Founder\CategoryController;
use App\Http\Controllers\Admin\Founder\DashboardController;
use App\Http\Controllers\Admin\Founder\ManagementFeeController;
use App\Http\Controllers\Admin\Founder\PostController;
use App\Http\Controllers\Admin\Founder\ReportController;
use App\Http\Controllers\Admin\Founder\UserController;
use App\Http\Controllers\Admin\Pemasukan\OrderManagementController;
use App\Http\Controllers\Admin\Pemasukan\ServiceController;
use App\Http\Controllers\Admin\Pengeluaran\ExpenseController;
use App\Http\Controllers\Admin\Pengeluaran\ExpenseCategoryController;

// [BARU] Import class yang dibutuhkan untuk Sitemap
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\CaseStudy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute
| ini dimuat oleh RouteServiceProvider dalam sebuah grup yang
| berisi middleware "web". Sekarang buatlah sesuatu yang luar biasa!
|
*/

// Rute utama dipisahkan agar memiliki nama 'home'
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// --- RUTE HALAMAN PUBLIK LAINNYA ---
Route::name('public.')->group(function () {
    Route::get('/tentang-kami', [LandingPageController::class, 'about'])->name('about');
    Route::get('/layanan', [LandingPageController::class, 'services'])->name('services');
    Route::get('/portfolio', [LandingPageController::class, 'portfolio'])->name('portfolio');
    Route::get('/portfolio/{caseStudy:slug}', [LandingPageController::class, 'showCaseStudy'])->name('portfolio.show');
    Route::get('/blog', [LandingPageController::class, 'blog'])->name('blog');
    Route::get('/blog/{post:slug}', [LandingPageController::class, 'showPost'])->name('blog.show');
    Route::get('/kontak', [LandingPageController::class, 'contact'])->name('contact');
    Route::post('/kontak', [ContactController::class, 'submit'])->name('contact.submit');
    Route::get('/mengapa-memilih-kami', [LandingPageController::class, 'whyChooseUs'])->name('why-choose-us');
});

Route::post('/midtrans/notification', [NotificationController::class, 'handle'])->name('midtrans.notification');

// [BARU] Rute untuk generate Sitemap secara otomatis
Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        // Menambahkan URL statis secara manual
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/tentang-kami')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create('/layanan')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create('/portfolio')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/kontak')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
        ->add(Url::create('/mengapa-memilih-kami')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

    // Menambahkan semua Post dari database
    Post::all()->each(function (Post $post) use ($sitemap) {
        $sitemap->add(
            Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.7)
        );
    });

    // Menambahkan semua Case Study dari database
    CaseStudy::all()->each(function (CaseStudy $caseStudy) use ($sitemap) {
        $sitemap->add(
            Url::create("/portfolio/{$caseStudy->slug}")
                ->setLastModificationDate($caseStudy->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.7)
        );
    });

    return $sitemap;
})->name('sitemap'); // Beri nama rute sitemap untuk referensi lebih mudah

// --- RUTE OTENTIKASI ---
require __DIR__ . '/auth.php';

// --- RUTE SETELAH LOGIN ---
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Logika Redirect Dashboard Utama ---
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Client')) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('admin.pemasukan.orders.index');
    })->name('dashboard');

    // --- Notifikasi ---
    Route::post('/notifications/mark-as-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAsRead');

    // ====================
    // == AREA CLIENT    ==
    // ====================
    Route::middleware(['role:Client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [ClientOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [ClientOrderController::class, 'show'])->name('orders.show');
        Route::get('/services', [ServiceListController::class, 'index'])->name('services.list');
        Route::post('/services/{service}/order', [ServiceListController::class, 'order'])->name('services.order');
        Route::get('/services/{service}', [ServiceListController::class, 'show'])->name('services.show');
        Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ClientProfileController::class, 'destroy'])->name('profile.destroy');
        // Rute Pembayaran (Lengkap)
        Route::prefix('orders/{order}')->name('payment.')->group(function () {
            Route::get('/choose-payment', [PaymentController::class, 'choosePayment'])->name('choose');
            Route::post('/proceed-to-payment', [PaymentController::class, 'saveNotesAndProceed'])->name('save_notes_and_proceed');
            Route::post('/pay-midtrans', [PaymentController::class, 'payWithMidtrans'])->name('pay_midtrans');
            Route::get('/payment-manual', [PaymentController::class, 'create'])->name('create');
            Route::post('/payment-manual', [PaymentController::class, 'store'])->name('store');
            Route::get('/payment-pending', [PaymentController::class, 'pending'])->name('pending');
            Route::get('/payment-success', [PaymentController::class, 'success'])->name('success');
            Route::get('/settlement', [PaymentController::class, 'showSettlementPage'])->name('settlement');
            Route::post('/settlement', [PaymentController::class, 'processSettlement'])->name('process_settlement');
        });
    });

    // ======================
    // == AREA ADMIN PUSAT ==
    // ======================
    Route::middleware(['role:Founder|Konten|Pemasukan dan Pengeluaran'])->prefix('admin')->name('admin.')->group(function () {

        // --- Dashboard, Profile, & Chat (Umum untuk semua Admin) ---
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/chat', fn() => view('admin.chat.index'))->name('chat.index');

        // (DIRAPIKAN) --- Fitur Founder & Konten ---
        // Anda bisa menyederhanakan ini dengan Route::resource
        Route::prefix('founder')->name('founder.')->group(function () {
            // Khusus Founder
            Route::middleware(['role:Founder'])->group(function () {
                // [MODIFIKASI] Gunakan 'except' pada resource untuk rute yang tidak digunakan
                Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
                Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
                Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
                Route::get('/management-fee', [ManagementFeeController::class, 'index'])->name('management-fee.index');
                Route::get('/management-fee/export', [ManagementFeeController::class, 'export'])->name('management-fee.export');
            });
            // Founder & Konten
            Route::middleware(['role:Founder|Konten'])->group(function () {
                Route::resource('posts', PostController::class);
                Route::post('posts/categories/ajax', [CategoryController::class, 'storeAjax'])->name('posts.categories.storeAjax');
                Route::resource('case-studies', CaseStudyController::class);
                Route::post('case-studies/categories/ajax', [CategoryController::class, 'storeCaseStudyAjax'])->name('case-studies.categories.storeAjax');
            });
        });

        // (DIRAPIKAN) --- Fitur Keuangan (Pemasukan & Pengeluaran) ---
        // Keduanya memiliki hak akses yang sama
        Route::middleware(['role:Founder|Pemasukan dan Pengeluaran'])->group(function () {
            // Pemasukan
            Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
                // [MODIFIKASI] Gunakan 'except' pada resource untuk rute yang tidak digunakan
                Route::resource('services', ServiceController::class)->except(['show']);
                Route::post('services/categories/ajax', [CategoryController::class, 'storeServiceAjax'])->name('services.categories.storeAjax');
                Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
                Route::patch('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.updateStatus');
                Route::post('/orders/{order}/verify-payment', [OrderManagementController::class, 'verifyPayment'])->name('orders.verifyPayment');
            });

            // Pengeluaran
            Route::prefix('pengeluaran')->name('pengeluaran.')->group(function () {
                // [MODIFIKASI] Gunakan 'except' pada resource untuk rute yang tidak digunakan
                Route::resource('expenses', ExpenseController::class)->except(['show']);
                Route::post('expense-categories/ajax', [ExpenseCategoryController::class, 'storeAjax'])->name('expense-categories.storeAjax');
                Route::patch('expense-categories/{category}', [ExpenseCategoryController::class, 'updateAjax'])->name('expense-categories.updateAjax');
                Route::delete('expense-categories/{category}', [ExpenseCategoryController::class, 'destroyAjax'])->name('expense-categories.destroyAjax');
            });
        });
    });
});
