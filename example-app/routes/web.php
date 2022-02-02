<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Persons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/',[Persons::class,'index']);


Route::get('/find/{values}',[Persons::class,'find'])->where(['name'=>'pet','id','name']);

Route::Post('/createpersons',[Persons::class,'create']);

Route::put('/editone',[Persons::class,'updateone']);

Route::delete('/deletemany',[Persons::class,'destroyMany']);

Route::delete('/deleteone/{id}',[Persons::class,'destroyOne']);

Route::get('/login',[LoginController::class,'LoginUsersGet']);

Route::post('/login',[LoginController::class,'loginUsersPost']);

Route::get('/register',[LoginController::class,'RegisterGet']);

Route::post('/register',[LoginController::class,'Register']);
