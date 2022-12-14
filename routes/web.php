<?php

use App\Http\Controllers\EmployeeController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
            Route::get('/', 'index')->name('employees');
            Route::get('/create', 'create')->name('employees.create');
            Route::get('/{employee}', 'show')->name('employees.show');
            Route::get('/{employee}/edit', 'edit')->name('employees.edit');
            Route::post('/', 'store')->name('employees.store');
            Route::put('/{employee}', 'update')->name('employees.update');
            Route::delete('/{employee}', 'destroy')->name('employees.destroy');
        });
    });
});

require __DIR__ . '/auth.php';
