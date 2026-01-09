<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ForumController as AdminForumController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Articles Routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Reports Routes
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/success/{reportNumber}', [ReportController::class, 'success'])->name('reports.success');
Route::get('/reports/track', [ReportController::class, 'track'])->name('reports.track');

// Forums Routes
Route::get('/forums', [ForumController::class, 'index'])->name('forums.index');
Route::get('/forums/{slug}', [ForumController::class, 'show'])->name('forums.show');

Route::middleware('auth')->group(function () {
    Route::get('/forums/create', [ForumController::class, 'create'])->name('forums.create');
    Route::post('/forums', [ForumController::class, 'store'])->name('forums.store');
    Route::get('/forums/{slug}/edit', [ForumController::class, 'edit'])->name('forums.edit');
    Route::put('/forums/{slug}', [ForumController::class, 'update'])->name('forums.update');
    Route::delete('/forums/{slug}', [ForumController::class, 'destroy'])->name('forums.destroy');
    Route::post('/forums/{slug}/comments', [ForumController::class, 'storeComment'])->name('forums.comments.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,moderator'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Articles Management
    Route::resource('articles', AdminArticleController::class);

    // Reports Management
    Route::resource('reports', AdminReportController::class);

    // Forums Management
    Route::resource('forums', AdminForumController::class);

    // Users Management (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Categories Management
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('errors.404');
});
