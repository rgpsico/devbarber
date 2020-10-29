<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbersController;
use App\Http\Controllers\testeController;
Route::get('/ping',function(){
return ['pong'=>true];
});

Route::get('/401',[AuthController::class,'unauthorized'])->name('login');

//Route::post('/ramdom',[BarbersController::class, 'createRandom']);
Route::post('/auth/login',[AuthController::class, 'login']);
Route::post('/auth/logout',[AuthController::class, 'logout']);
Route::post('/auth/refresh',[AuthController::class, 'refresh']);
Route::post('/user',[AuthController::class, 'create']);

Route::get('/user',[UserController::class,'read']);
Route::put('/user',[UserController::class],'update');
Route::get('/user/favorites',[UserController::class],'getFavorites');
Route::post('/user/favorite',[UserController::class],'addFavorite');
Route::get('/user/appointments',[UserController::class], 'getAppointments');


Route::get('/barbers',[BarbersController::class, 'list']);
Route::get('/barber/{id}',[BarbersController::class,'one']);
Route::post('/barber/{id}/appointment',[BarbersController::class,'setAppointment']);

Route::get('/search',[BarbersController::class,'search']);
Route::get('/teste',  [testeController::class,'teste']);