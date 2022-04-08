<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Data_Generator;
use App\Http\Controllers\DayRecords;
use App\Http\Controllers\MonthlyReport;
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
        return to_route('dashboard');
    }
})->name('home');

Route::get('/day_records', [DayRecords::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('point', [DayRecords::class, 'point'])->middleware(['auth']);

Route::get('/monthly_report', [MonthlyReport::class, 'index'])->middleware(['auth']);


Route::get('/data_generator', [Data_Generator::class, 'dataGenerator'])->middleware(['auth']);

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';

