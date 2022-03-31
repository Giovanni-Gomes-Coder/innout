<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

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
    $date = (new DateTime())->getTimestamp();
    $today = strftime('%d de %B de %Y', $date);

    if(!auth()->check()){
        return view('../auth/login');
    } else {
        return view('/day_records', ['today' => $today]);
    }
});

Route::get('/day_records', function () {
    $date = (new DateTime())->getTimestamp();
    $today = strftime('%d de %B de %Y', $date);
    return view('day_records', ['today' => $today]);
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';

