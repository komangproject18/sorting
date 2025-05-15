<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SortingController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('index');
});

Route::get('/sorting', [SortingController::class, 'index'])->name('index');
Route::post('/sorting/sort', [SortingController::class, 'sort'])->name('sort');

