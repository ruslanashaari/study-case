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

Route::get('employees', [EmployeeController::class, 'index'])
    ->name('employees.index')
    ->middleware('auth', 'verified');

Route::get('employees/create', [EmployeeController::class, 'create'])
    ->name('employees.create')
    ->middleware('auth', 'verified');

Route::post('employees', [EmployeeController::class, 'store'])
    ->name('employees.store')
    ->middleware('auth', 'verified');

Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])
    ->name('employees.edit')
    ->middleware('auth', 'verified');

Route::get('employees/{employee}', [EmployeeController::class, 'show'])
    ->name('employees.show')
    ->middleware('auth', 'verified');

Route::put('employees/{employee}', [EmployeeController::class, 'update'])
    ->name('employees.update')
    ->middleware('auth', 'verified');

Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])
    ->name('employees.destroy')
    ->middleware('auth', 'verified');

Route::get('/dashboard', function () {
    return redirect()->route('employees.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('addresses', [EmployeeController::class, 'index'])
    ->name('addresses.index')
    ->middleware('auth', 'verified');


require __DIR__.'/auth.php';
