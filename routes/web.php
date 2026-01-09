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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports Management
    Route::get('/reports', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $reports = \App\Models\Report::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    })->name('reports.index');

    Route::get('/reports/{report}', function(\App\Models\Report $report) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $report->load(['user', 'category']);

        return view('admin.reports.show', compact('report'));
    })->name('reports.show');

    // Articles Management
    Route::get('/articles', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $articles = \App\Models\Article::with('author')
            ->latest()
            ->paginate(20);

        return view('admin.articles.index', compact('articles'));
    })->name('articles.index');

    Route::get('/articles/create', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $categories = \App\Models\Category::where('type', 'article')->get();

        return view('admin.articles.create', compact('categories'));
    })->name('articles.create');

    Route::get('/articles/{article}', function(\App\Models\Article $article) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $article->load('author');

        return view('admin.articles.show', compact('article'));
    })->name('articles.show');

    // Forums Management
    Route::get('/forums', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $forums = \App\Models\Forum::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.forums.index', compact('forums'));
    })->name('forums.index');

    Route::get('/forums/{forum}', function(\App\Models\Forum $forum) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $forum->load(['user', 'comments']);

        return view('admin.forums.show', compact('forum'));
    })->name('forums.show');

    // Users Management
    Route::get('/users', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $users = \App\Models\User::latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    })->name('users.index');

    Route::get('/users/{user}', function(\App\Models\User $user) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $user->loadCount(['reports', 'forums', 'articles']);

        return view('admin.users.show', compact('user'));
    })->name('users.show');

    // Categories Management
    Route::get('/categories', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $categories = \App\Models\Category::withCount(['reports', 'articles'])
            ->latest()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    })->name('categories.index');

    Route::get('/categories/create', function() {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);
        return view('admin.categories.create');
    })->name('categories.create');

    Route::get('/categories/{category}', function(\App\Models\Category $category) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $category->loadCount(['reports', 'articles']);

        return view('admin.categories.show', compact('category'));
    })->name('categories.show');

    Route::post('/categories', function(\Illuminate\Http\Request $request) {
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'type' => 'required|in:report,article',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        \App\Models\Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    })->name('categories.store');

    // Resource routes (when controllers are ready)
    // Route::resource('articles', AdminArticleController::class);
    // Route::resource('reports', AdminReportController::class);
    // Route::resource('forums', AdminForumController::class);
    // Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        $myReports = \App\Models\Report::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        $myForums = \App\Models\Forum::where('user_id', auth()->id())
            ->withCount('comments')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('myReports', 'myForums'));
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

        return back()->with('success', 'Profile berhasil diperbarui!');
    })->name('profile.update');

    Route::get('/my-reports', function () {
        $reports = \App\Models\Report::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('dashboard.reports', compact('reports'));
    })->name('reports');

    Route::get('/my-forums', function () {
        $forums = \App\Models\Forum::where('user_id', auth()->id())
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('dashboard.forums', compact('forums'));
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
