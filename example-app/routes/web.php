<?php

use App\Http\Controllers\Persons;
use Illuminate\Http\Request;
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

Route::get('/',[Persons::class,'index']);


Route::get('/find/{name}/{values}',[Persons::class,'find'])->where(['name'=>'pet','id','name']);


Route::delete('/persons/{id}',[Persons::class,'destroy']);

