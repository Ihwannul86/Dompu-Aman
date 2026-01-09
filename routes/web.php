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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Articles Routes
|--------------------------------------------------------------------------
*/

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
*/

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/track', [ReportController::class, 'track'])->name('reports.track');

Route::middleware('auth')->group(function () {
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/success/{reportNumber}', [ReportController::class, 'success'])->name('reports.success');
});

/*
|--------------------------------------------------------------------------
| Forums Routes
|--------------------------------------------------------------------------
*/

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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Manual admin check in controllers

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Articles Management
    Route::get('/articles', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.articles.index', [
            'articles' => \App\Models\Article::latest()->paginate(20)
        ]);
    })->name('articles.index');

    Route::get('/articles/create', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.articles.create');
    })->name('articles.create');

    // Reports Management
    Route::get('/reports', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.reports.index', [
            'reports' => \App\Models\Report::latest()->paginate(20)
        ]);
    })->name('reports.index');

    Route::get('/reports/{report}', function(\App\Models\Report $report) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.reports.show', compact('report'));
    })->name('reports.show');

    // Forums Management
    Route::get('/forums', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.forums.index', [
            'forums' => \App\Models\Forum::latest()->paginate(20)
        ]);
    })->name('forums.index');

    // Users Management
    Route::get('/users', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.users.index', [
            'users' => \App\Models\User::latest()->paginate(20)
        ]);
    })->name('users.index');

    Route::get('/users/{user}', function(\App\Models\User $user) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.users.show', compact('user'));
    })->name('users.show');

    // Categories Management
    Route::get('/categories', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.categories.index', [
            'categories' => \App\Models\Category::latest()->paginate(20)
        ]);
    })->name('categories.index');

    Route::get('/categories/create', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.categories.create');
    })->name('categories.create');

    // Resource routes (when controllers are ready)
    // Route::resource('articles', AdminArticleController::class);
    // Route::resource('reports', AdminReportController::class);
    // Route::resource('forums', AdminForumController::class);
    // Route::resource('users', UserController::class);
    // Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index', [
            'myReports' => \App\Models\Report::where('user_id', auth()->id())->latest()->limit(5)->get(),
            'myForums' => \App\Models\Forum::where('user_id', auth()->id())->latest()->limit(5)->get(),
        ]);
    })->name('index');

    Route::get('/profile', function () {
        return view('dashboard.profile');
    })->name('profile');

    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    })->name('profile.update');

    Route::get('/my-reports', function () {
        return view('dashboard.reports', [
            'reports' => \App\Models\Report::where('user_id', auth()->id())->latest()->paginate(10)
        ]);
    })->name('reports');

    Route::get('/my-forums', function () {
        return view('dashboard.forums', [
            'forums' => \App\Models\Forum::where('user_id', auth()->id())->latest()->paginate(10)
        ]);
    })->name('forums');
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('errors.404');
});
