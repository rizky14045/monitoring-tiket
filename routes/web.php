<?php

use App\Models\Monitoring;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;

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

Route::get('/login', function () {
    return view('user.login');
});
Route::get('/register', function () {
    return view('user.register');
});
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/monitoring-data', [DashboardController::class, 'getMonitoringData'])->name('monitoring.data');
Route::get('/monitoring-data-second', [DashboardController::class, 'getMonitoringDataSecond'])->name('monitoring.data2');
Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
Route::prefix('monitoring')->group(function () {
    Route::get('/', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/edit/{id}', [MonitoringController::class, 'edit'])->name('monitoring.edit');
    Route::patch('/edit/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::delete('/destroy/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    Route::post('/import', [MonitoringController::class, 'import'])->name('monitoring.import');
    
});

Route::get('/truncate', function () {
    Monitoring::truncate();
    return redirect()->route('monitoring.index')->with('success', 'Monitoring berhasil di hapus');
});
