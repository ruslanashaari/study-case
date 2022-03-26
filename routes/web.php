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

Route::get('/dashboard', function () {
    return redirect()->route('employees.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('employees.')->prefix('employees')->group(function () {

    Route::get('/', [EmployeeController::class, 'index'])
    ->name('index')
    ->middleware('auth', 'verified');

    Route::get('/create', [EmployeeController::class, 'create'])
        ->name('create')
        ->middleware('auth', 'verified');

    Route::post('', [EmployeeController::class, 'store'])
        ->name('store')
        ->middleware('auth', 'verified');

    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])
        ->name('edit')
        ->middleware('auth', 'verified');

    Route::get('/{employee}', [EmployeeController::class, 'show'])
        ->name('show')
        ->middleware('auth', 'verified');

    Route::put('/{employee}', [EmployeeController::class, 'update'])
        ->name('update')
        ->middleware('auth', 'verified');

    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])
        ->name('destroy')
        ->middleware('auth', 'verified');

});

Route::name('addresses.')->prefix('addresses')->group(function () {

    Route::get('/', [AddressController::class, 'index'])
    ->name('index')
    ->middleware('auth', 'verified');

    Route::get('/create', [AddressController::class, 'create'])
        ->name('create')
        ->middleware('auth', 'verified');

    Route::post('', [AddressController::class, 'store'])
        ->name('store')
        ->middleware('auth', 'verified');

    Route::get('/{address}/edit', [AddressController::class, 'edit'])
        ->name('edit')
        ->middleware('auth', 'verified');

    Route::get('/{address}', [AddressController::class, 'show'])
        ->name('show')
        ->middleware('auth', 'verified');

    Route::put('/{address}', [AddressController::class, 'update'])
        ->name('update')
        ->middleware('auth', 'verified');

    Route::delete('/{address}', [AddressController::class, 'destroy'])
        ->name('destroy')
        ->middleware('auth', 'verified');

});


require __DIR__.'/auth.php';
