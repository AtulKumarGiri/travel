<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CmsPageController;

Route::get('/', function () { return view('front.index');})->name('home');
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', function () { return view('auth.register');})->name('register');
Route::post('/register', function () { return redirect()->route('dashboard');})->name('register.submit');
Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');

Route::get('/create-admin', [UserController::class, 'createAdmin']);
Route::get('/create-partner', [UserController::class, 'createPartner']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Role-based dashboards
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/partner/dashboard', [DashboardController::class, 'index'])->name('partner.dashboard');
Route::get('/supplier/dashboard', [DashboardController::class, 'index'])->name('supplier.dashboard');
Route::get('/employee/dashboard', [DashboardController::class, 'index'])->name('employee.dashboard');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('password.change');
Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');
Route::get('/settings', [UserController::class, 'settings'])->name('settings');


/* Admin CMS */
Route::middleware(['web'])->group(function () {
    Route::get('/admin/cms', [CmsPageController::class, 'index'])->name('cms.index');
    Route::get('/admin/cms/create', [CmsPageController::class, 'create'])->name('cms.create');
    Route::post('/admin/cms/store', [CmsPageController::class, 'store'])->name('cms.store');
    Route::post('/admin/cms/destroy', [CmsPageController::class, 'destroy'])->name('cms.destroy');
    Route::get('/admin/cms/{id}/edit', [CmsPageController::class, 'edit'])->name('cms.edit');
    Route::put('/admin/cms/{id}', [CmsPageController::class, 'update'])->name('cms.update');
});

/* Frontend CMS pages */
Route::get('/{slug}', [CmsPageController::class, 'show'])->name('cms.show');
Route::get('/documents/create', [UserController::class, 'createDocument'])->name('documents.create');
Route::get('/documents/edit', [UserController::class, 'editDocument'])->name('documents.edit');
Route::get('/documents/show/{id}', [UserController::class, 'showDocument'])->name('documents.show');
Route::post('/documents/autosave', [UserController::class, 'autosave'])->name('documents.autosave');
Route::get('/admin/documents', [UserController::class, 'documentsIndex'])->name('documents.index');