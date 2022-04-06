<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Data_Generator;
use Illuminate\Support\Facades\Route;
use App\Models\WorkingHours;
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
    if(!auth()->check()){
        return view('../auth/login');
    } else {
        return redirect()->route('dashboard');
    }
})->name('home');

Route::get('/day_records', function () {
    $date = (new DateTime())->getTimestamp();
    $today = strftime('%d de %B de %Y', $date);
    return view('day_records', ['today' => $today]);
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::get('/data_generator', [Data_Generator::class, 'dataGenerator'])->middleware(['auth']);

Route::get('point', [Data_Generator::class, 'point'])->middleware(['auth']);

Route::post('forcedPoint', [Data_Generator::class, 'forcedPoint'])->middleware(['auth']);

require __DIR__.'/auth.php';

