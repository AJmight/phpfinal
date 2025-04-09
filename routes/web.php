<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeamController; // Add this
use App\Http\Controllers\FixtureController; // Add this
use App\Http\Controllers\Admin\FixtureAdminController; // For Admin Fixture Management

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---

// Welcome/Home Page (Changed from default welcome)
Route::get('/', [HomeController::class, 'welcome'])->name('welcome'); // Changed to use a controller method

// Teams Page
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show'); // To view a specific team

// Fixtures Page
Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');

// About Us Page (Using existing PageController structure)
Route::get('/about-us', [PageController::class, 'index'])->name('page.index')->defaults('page', 'about-us'); // Ensure 'about-us.blade.php' exists

// Authentication Routes (Keep as is)
Auth::routes();

// --- Authenticated User Routes (Non-Admin) ---

// Dashboard (If you still want a separate logged-in dashboard)
// Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard'); // Or remove if '/' is the main logged-in view too

// Profile Routes (Keep as is)
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});


// --- Admin Routes ---
Route::middleware(['auth', /* Add Admin Role Middleware Here e.g., 'role:admin' */])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard (Optional)
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard'); // Example

    // User Management (Use existing or create specific Admin version)
    Route::resource('users', App\Http\Controllers\Admin\UserAdminController::class); // Example: Separate Admin Controller

    // Team Management
    Route::resource('teams', App\Http\Controllers\Admin\TeamAdminController::class);

    // Player Management
    Route::resource('players', App\Http\Controllers\Admin\PlayerAdminController::class); // Needs creating

    // Fixture/Game Management (Including Results)
    Route::resource('fixtures', App\Http\Controllers\Admin\FixtureAdminController::class);
    Route::post('fixtures/{fixture}/results', [FixtureAdminController::class, 'updateResult'])->name('fixtures.updateResult'); // Route to update results
    Route::post('fixtures/generate', [FixtureAdminController::class, 'generateFixtures'])->name('fixtures.generate'); // Route to trigger generation

    // Referee Management
    Route::resource('referees', App\Http\Controllers\Admin\RefereeAdminController::class); // Needs creating

    // Role/Permission Management (If using a package like Spatie/laravel-permission)
    // Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    // Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class);

});
Route::redirect('/dashboard', '/admin')->name('dashboard');

// Fallback for generic pages (if needed, ensure this doesn't conflict)
// Route::group(['middleware' => 'auth'], function () {
//  Route::get('{page}', [PageController::class, 'index'])->name('page.index');
// });