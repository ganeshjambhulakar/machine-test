<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineTest;
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


Route::get('/add_ball', [MachineTest::class,'add_ball']);
Route::post('/add_ball', [MachineTest::class,'store_ball']);
Route::get('/add_bucket',[MachineTest::class,'add_bucket']);
Route::post('/add_bucket',[MachineTest::class,'store_bucket']);
Route::get('/edit_bucket/{id}', [MachineTest::class,'edit_bucket']);
Route::post('/edit_bucket/{id}', [MachineTest::class,'store_bucket']);
Route::get('/edit_ball/{id}',[MachineTest::class,'edit_ball']);
Route::post('/edit_ball/{id}',[MachineTest::class,'store_ball']);
Route::post('/savetest',[MachineTest::class,'test']);
Route::get('/', [MachineTest::class,'dashboard']);
