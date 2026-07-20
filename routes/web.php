<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\UserLostPasswordController;
use App\Http\Controllers\Auth\AdminLostPasswordController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AttractionController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Auth;

// SHOW LOGIN PAGE
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// OPEN REGISTER PAGE
Route::get('/register', function () {
    return view('auth.user-register');
})->name('register');

// REGISTER  
Route::post('/user/register', [UserAuthController::class, 'register'])
    ->name('user.register');

// LOGIN  
Route::post('/login/user', [AuthController::class, 'userLogin'])->name('login.user');
Route::post('/login/admin', [AuthController::class, 'adminLogin'])->name('login.admin');

// USER RESET PASSWORD 
Route::get('/user/reset-password', [UserLostPasswordController::class, 'showResetForm'])->name('user.password.reset');
Route::post('/user/reset-password', [UserLostPasswordController::class, 'updatePassword'])->name('user.password.update');

// ADMIN RESET PASSWORD 
Route::get('/admin/reset-password', [AdminLostPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminLostPasswordController::class, 'updatePassword'])->name('admin.password.update');

// USER PROTECTED ROUTES 
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])
        ->name('user.dashboard');

    // View place
    Route::get('/user/place/{id}', [UserDashboardController::class, 'show'])
        ->name('place.show');

    // Save plan
    Route::post('/user/save-plan', [UserDashboardController::class, 'savePlan'])
        ->name('plan.save');

    // View plans
    Route::get('/user/plans', [UserDashboardController::class, 'plans'])
        ->name('plan.view');

    // Delete plan
    Route::delete('/plan/delete/{id}', [UserDashboardController::class, 'deletePlan'])
        ->name('plan.delete');

    // Show One Day Plan page
    Route::get('plan/one-day-plan', [UserDashboardController::class, 'showOneDayPlan'])
        ->name('plan.show-one-day-plan');

    // Add a place to One Day Plan
    Route::post('plan/one-day-plan/add', [UserDashboardController::class, 'addToOneDayPlan'])
        ->name('plan.add-to-one-day-plan');

    // Route update the order of places in One Day Plan
    Route::post('/plan/update-order', [UserDashboardController::class, 'updateOrder'])
        ->name('plan.update-order');

    // Generate route
    Route::get('/plan/route', [UserDashboardController::class, 'showRoutePage'])
        ->name('plan.generate-route');

    // Save route
    Route::post('/plan/save-route-session', function (Request $request) {

        $items = $request->input('items', []);

        // FORCE FLAT ARRAY ALWAYS
        $ids = collect($items)
            ->flatten()
            ->map(fn($id) => is_array($id) ? ($id['id'] ?? null) : $id)
            ->filter()
            ->values()
            ->toArray();

        session(['route_order' => $ids]);

        return response()->json([
            'status' => 'ok',
            'saved' => $ids
        ]);
    });
});

// CONTACT US PAGE
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// USER LOGOUT
Route::post('/logout', [UserDashboardController::class, 'logout'])
    ->name('logout');


// ========================= ADMIN PANEL =============================
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // CATEGORY MODAL
        Route::resource('categories', CategoryController::class)
            ->except(['create', 'edit', 'show']);

        // ATTRACTION MODAL
        Route::resource('attractions', AttractionController::class)
            ->except(['create', 'edit', 'show']);
    });

// ADMIN LOGOUT 
Route::post('/admin/logout', [UserDashboardController::class, 'admin.logout'])
    ->name('admin.logout');
