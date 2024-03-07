<?php

use App\Http\Controllers\AgeGroupController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('records.index');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // records routes
    Route::prefix('records')->group(function () {
        Route::get('/', [RecordsController::class, 'index'])->name('records.index');
        Route::get('/fetch', [RecordsController::class, 'fetch'])->name('records.fetch');
        Route::post('/', [RecordsController::class, 'store'])->name('records.store');
        Route::post('/edit', [RecordsController::class, 'edit'])->name('records.edit');
        Route::post('/show', [RecordsController::class, 'show'])->name('records.show');
        Route::put('/{record}/update', [RecordsController::class, 'update'])->name('records.update');
        Route::post('/destroy', [RecordsController::class, 'destroy'])->name('records.destroy');
    });
    // end of records routes
});

Route::middleware(['admin'])->group(function () {
    // setup routes
    Route::prefix('setup')->group(function () {

        Route::prefix('records')->group(function () {
            Route::post('/download', [RecordsController::class, 'download'])->name('records.download');
        });

        // user routes
        Route::prefix('user')->group(function () {
            Route::get('/', [RegisteredUserController::class, 'index'])->name('user.index');
            Route::get('/fetch', [RegisteredUserController::class, 'fetch'])->name('user.fetch');
            Route::post('/', [RegisteredUserController::class, 'store'])->name('user.store');
            Route::post('/edit-profile', [RegisteredUserController::class, 'editProfile'])->name('user.edit.profile');
            Route::put('/{user}/update-profile', [RegisteredUserController::class, 'updateProfile'])->name('user.update.profile');
            Route::put('/{user}/update-password', [RegisteredUserController::class, 'updatePassword'])->name('user.update.password');
            Route::post('/destroy', [RegisteredUserController::class, 'destroy'])->name('user.destroy');
        });
        // end of user routes

        // age group routes
        Route::prefix('age-group')->group(function () {
            Route::get('/', [AgeGroupController::class, 'index'])->name('age.index');
            Route::get('/fetch', [AgeGroupController::class, 'fetch'])->name('age.fetch');
            Route::post('/', [AgeGroupController::class, 'store'])->name('age.store');
            Route::post('/edit', [AgeGroupController::class, 'edit'])->name('age.edit');
            Route::put('/{ageGroup}/update', [AgeGroupController::class, 'update'])->name('age.update');
            Route::post('/destroy', [AgeGroupController::class, 'destroy'])->name('age.destroy');
        });
        // end of age group routes

        // product categories routes
        Route::prefix('product-category')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->name('product.index');
            Route::get('/fetch', [ProductCategoryController::class, 'fetch'])->name('product.fetch');
            Route::post('/', [ProductCategoryController::class, 'store'])->name('product.store');
            Route::post('/edit', [ProductCategoryController::class, 'edit'])->name('product.edit');
            Route::put('/{productCategory}/update', [ProductCategoryController::class, 'update'])->name('product.update');
            Route::post('/destroy', [ProductCategoryController::class, 'destroy'])->name('product.destroy');
        });
        // end of product categories routes

        // branches routes
        Route::prefix('branches')->group(function () {
            Route::get('/', [BranchController::class, 'index'])->name('branch.index');
            Route::get('/fetch', [BranchController::class, 'fetch'])->name('branch.fetch');
            Route::post('/', [BranchController::class, 'store'])->name('branch.store');
            Route::post('/edit', [BranchController::class, 'edit'])->name('branch.edit');
            Route::put('/{branch}/update', [BranchController::class, 'update'])->name('branch.update');
            Route::post('/destroy', [BranchController::class, 'destroy'])->name('branch.destroy');
        });
        // end of branches routes
    });
    // end of setup routes
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
