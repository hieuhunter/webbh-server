<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ql_bachhoaxanhController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('sanpham', [ql_bachhoaxanhController::class, 'sanpham']);
Route::get('sanpham/{id}', [ql_bachhoaxanhController::class, 'ctsanpham']);
Route::get('danhmuc', [ql_bachhoaxanhController::class, 'danhmuc']);
Route::get('danhmuc/{id}', [ql_bachhoaxanhController::class, 'sanphamtheodm']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('danhsach_gh', [ql_bachhoaxanhController::class, 'danhsachgiohang']);
    Route::delete('xoagh', [ql_bachhoaxanhController::class, 'xoagiohang']);
    Route::delete('xoaall', [ql_bachhoaxanhController::class, 'xoatatcagh']);
    Route::get('addgiohang', [ql_bachhoaxanhController::class, 'addgiohang']);
    Route::post('thanhtoan', [ql_bachhoaxanhController::class, 'thanhtoan']);
    Route::get('thongtin', [ql_bachhoaxanhController::class, 'thongtin']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});
