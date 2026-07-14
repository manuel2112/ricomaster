<?php

use App\Http\Controllers\Admin\AssociatedController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\ClientFinalController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ParameterController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\CampaignController as PublicCampaignController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController as PublicHomeController;
use App\Http\Controllers\Public\MenuController as PublicMenuController;
use App\Http\Controllers\Public\MinutaController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return 'Cache Cleared';
});

Route::get('/', [PublicHomeController::class, 'get'])->name('public.home');
Route::get('/about', [AboutController::class, 'get'])->name('public.about');
Route::get('/minuta', [MinutaController::class, 'get'])->name('public.minuta');
Route::get('/menu', [PublicMenuController::class, 'get'])->name('public.menu');
Route::get('/campaign', [PublicCampaignController::class, 'get'])->name('public.campaign');
Route::get('/associated', [PublicMenuController::class, 'associated'])->name('public.associated');
Route::get('/contact', [ContactController::class, 'get'])->name('public.contact');

Route::get('/pdf/final/detail/{order}/{isCampaign}', [ReportController::class, 'finalDetail'])->name('final.detail.pdf');
Route::get('/pdf/final/detail-day/{day}', [ReportController::class, 'finalDetailDay'])->name('final.detail.day.pdf');
Route::get('/pdf/campaign/detail-day/{day}', [ReportController::class, 'campaignDetailDay'])->name('campaign.detail.day.pdf');
Route::get('/pdf/associated/detail/{order}', [ReportController::class, 'associatedDetail'])->name('associated.detail.pdf');
Route::get('/pdf/associated/detail-day/{day}', [ReportController::class, 'associatedDetailDay'])->name('associated.detail.day.pdf');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'get'])->name('admin.home');
    Route::get('/admin/orders-associated', [AssociatedController::class, 'order'])->name('admin.orders.associated');
    Route::get('/admin/whatsapp-associated', [AssociatedController::class, 'whatsapp'])->name('admin.whatsapp.associated');
    Route::get('/admin/orders-associated-day/{date}', [AssociatedController::class, 'orderDetail'])->name('admin.orders.associated.day');
    Route::get('/admin/orders-final', [ClientFinalController::class, 'get'])->name('admin.orders.final');
    Route::get('/admin/whatsapp-final', [ClientFinalController::class, 'whatsapp'])->name('admin.whatsapp.final');
    Route::get('/admin/orders-final-day/{date}', [ClientFinalController::class, 'orderDetail'])->name('admin.orders.final.day');
    Route::get('/admin/detail-order/{date}', [HomeController::class, 'orderDetail'])->name('admin.order.detail');
    Route::get('/admin/minuta', [BillController::class, 'get'])->name('admin.bill');
    Route::get('/admin/minuta/crear/{type}', [BillController::class, 'create'])->name('admin.bill.create');
    Route::get('/admin/minuta/editar/{id}', [BillController::class, 'edit'])->name('admin.bill.edit');
    Route::get('/admin/associated', [AssociatedController::class, 'get'])->name('admin.associated');
    Route::get('/admin/parameter', [ParameterController::class, 'get'])->name('admin.parameter');
    Route::get('/admin/menu', [MenuController::class, 'get'])->name('admin.menu');
    Route::get('/admin/campaign', [CampaignController::class, 'get'])->name('admin.campaign');
    Route::get('/admin/campaign-final-day/{date}', [CampaignController::class, 'orderDetail'])->name('admin.campaign.final.day');
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
