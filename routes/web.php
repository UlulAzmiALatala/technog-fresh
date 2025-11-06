<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Controller Publik ---
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Midtrans\NotificationController;
use App\Http\Controllers\SubscriberController; // DITAMBAHKAN

// --- Controller Klien ---
use App\Http\Controllers\Client\ClientDashboardController;
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
use App\Http\Controllers\Admin\Founder\TestimonialController;
use App\Http\Controllers\Admin\Pemasukan\OrderManagementController;
use App\Http\Controllers\Admin\Pemasukan\ServiceController;
use App\Http\Controllers\Admin\Pengeluaran\ExpenseController;
use App\Http\Controllers\Admin\Pengeluaran\ExpenseCategoryController;
use App\Http\Controllers\Admin\Founder\SettingsController;
use App\Http\Controllers\Admin\Founder\SocialLinkController;
use App\Http\Controllers\Admin\Founder\LogoController;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\CaseStudy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE FITUR SUBSCRIBE (BARU) ---
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');


// --- RUTE PUBLIK ---
Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::name('public.')->group(function () {
    Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
    Route::get('/services', [LandingPageController::class, 'services'])->name('services');
    Route::get('/success-stories', [LandingPageController::class, 'portfolio'])->name('portfolio');
    Route::get('/success-stories/{caseStudy:slug}', [LandingPageController::class, 'showCaseStudy'])->name('portfolio.show');
    Route::get('/blog', [LandingPageController::class, 'blog'])->name('blog');
    Route::get('/blog/{post:slug}', [LandingPageController::class, 'showPost'])->name('blog.show');
    Route::get('/contact', [LandingPageController::class, 'contact'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
    Route::get('/why-choose-us', [LandingPageController::class, 'whyChooseUs'])->name('why-choose-us');
});

Route::permanentRedirect('/tentang-kami', '/about-us');
Route::permanentRedirect('/layanan', '/services');
Route::permanentRedirect('/portfolio', '/success-stories');
Route::permanentRedirect('/kontak', '/contact');
Route::permanentRedirect('/mengapa-memilih-kami', '/why-choose-us');

Route::post('/midtrans/notification', [NotificationController::class, 'handle'])->name('midtrans.notification');

// --- SITEMAP ---
Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/about-us')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create('/services')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create('/success-stories')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create('/contact')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
        ->add(Url::create('/why-choose-us')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

    Post::all()->each(function (Post $post) use ($sitemap) {
        $sitemap->add(
            Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.7)
        );
    });

    CaseStudy::all()->each(function (CaseStudy $caseStudy) use ($sitemap) {
        $sitemap->add(
            Url::create("/success-stories/{$caseStudy->slug}")
                ->setLastModificationDate($caseStudy->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.7)
        );
    });

    return $sitemap;
})->name('sitemap');


require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Client')) {
            return redirect()->route('client.dashboard');
        }

        if ($user->hasRole('Konten') && !$user->hasAnyRole(['Founder', 'Pemasukan dan Pengeluaran'])) {
            return redirect()->route('admin.founder.posts.index');
        }

        return redirect()->route('admin.pemasukan.orders.index');
    })->name('dashboard');

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
        Route::get('/orders/{order}/download-invoice', [ClientOrderController::class, 'downloadInvoice'])->name('orders.download_invoice');
        Route::post('/orders/{order}/testimonial', [ClientOrderController::class, 'storeTestimonial'])->name('orders.testimonial.store');
        Route::get('/services', [ServiceListController::class, 'index'])->name('services.list');
        Route::post('/services/{service}/order', [ServiceListController::class, 'order'])->name('services.order');
        Route::get('/services/{service}', [ServiceListController::class, 'show'])->name('services.show');
        Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ClientProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/validate-discount', [PaymentController::class, 'validateDiscountCode'])->name('payment.validate_discount');

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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/chat', fn() => view('admin.chat.index'))->name('chat.index');

        // --- Fitur Founder & Konten ---
        Route::prefix('founder')->name('founder.')->group(function () {

            // Khusus Founder
            Route::middleware(['role:Founder'])->group(function () {
                Route::resource('users', UserController::class)->except(['create', 'store']);

                Route::prefix('settings')->name('settings.')->group(function () {
                    Route::get('/contact', [SettingsController::class, 'contactIndex'])->name('contact.index');
                    Route::patch('/contact', [SettingsController::class, 'contactUpdate'])->name('contact.update');
                    Route::resource('social-links', SocialLinkController::class)->except(['show']);
                    Route::resource('logos', LogoController::class)->except(['show']);
                });

                Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
                Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
                Route::get('/management-fee', [ManagementFeeController::class, 'index'])->name('management-fee.index');
                Route::get('/management-fee/export', [ManagementFeeController::class, 'export'])->name('management-fee.export');
            });

            // Founder & Konten
            Route::middleware(['role:Founder|Konten'])->group(function () {
                Route::resource('posts', PostController::class)->except(['create', 'edit']);
                Route::post('posts/categories/ajax', [CategoryController::class, 'storeAjax'])->name('posts.categories.storeAjax');

                Route::resource('case-studies', CaseStudyController::class)->except(['show', 'create', 'edit']);
                Route::post('case-studies/categories/ajax', [CategoryController::class, 'storeCaseStudyAjax'])->name('case-studies.categories.storeAjax');
            });
        });

        Route::resource('testimonials', \App\Http\Controllers\Admin\Founder\TestimonialController::class);

        // --- Fitur Keuangan (Pemasukan & Pengeluaran) ---
        // Middleware di sini HANYA untuk Founder & Pemasukan
        Route::middleware(['role:Founder|Pemasukan dan Pengeluaran'])->group(function () {

            // Pemasukan
            Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
                Route::resource('services', ServiceController::class)->except(['show']);
                Route::post('services/categories/ajax', [CategoryController::class, 'storeServiceAjax'])->name('services.categories.storeAjax');
                Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
                Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
                Route::patch('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.updateStatus');
                Route::post('/orders/{order}/verify-payment', [OrderManagementController::class, 'verifyPayment'])->name('orders.verifyPayment');
                Route::patch('/orders/{order}/negotiated-price', [OrderManagementController::class, 'updateNegotiatedPrice'])->name('orders.updateNegotiatedPrice');
                Route::patch('/orders/{order}/progress', [OrderManagementController::class, 'updateProgress'])->name('orders.updateProgress');
                Route::resource('discounts', \App\Http\Controllers\Admin\Pemasukan\DiscountController::class);
            });

            // Pengeluaran
            Route::prefix('pengeluaran')->name('pengeluaran.')->group(function () {
                Route::resource('expenses', ExpenseController::class)->except(['show']);
                Route::post('expense-categories/ajax', [ExpenseCategoryController::class, 'storeAjax'])->name('expense-categories.storeAjax');
                Route::patch('expense-categories/{category}', [ExpenseCategoryController::class, 'updateAjax'])->name('expense-categories.updateAjax');
                Route::delete('expense-categories/{category}', [ExpenseCategoryController::class, 'destroyAjax'])->name('expense-categories.destroyAjax');
            });
        });
    });
});
