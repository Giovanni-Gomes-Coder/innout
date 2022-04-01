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
    $date = (new DateTime())->getTimestamp();
    $today = strftime('%d de %B de %Y', $date);
    $records = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
    if(!auth()->check()){
        return view('../auth/login');
    } else {
        return view('/day_records', ['today' => $today, 'records' => $records]);
    }
});

Route::get('/day_records', function () {
    $date = (new DateTime())->getTimestamp();
    $today = strftime('%d de %B de %Y', $date);
    $records = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
    return view('day_records', ['today' => $today, 'records' => $records]);
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::get('/data_generator', [Data_Generator::class, 'dataGenerator'])->middleware(['auth']);

require __DIR__.'/auth.php';

