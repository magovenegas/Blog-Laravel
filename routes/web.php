<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});


//Modulos post
//Ruta para crear el CRUD de visualizaacion de Post
Route::get('/Posts', [PostController::class, 'index']);
//Se carga el data table
Route::get('/Posts/json-data', [PostController::class, 'getJsonData']);
//Crear Registro Modulo Post
Route::post('/Posts', [PostController::class, 'store']);
//Modificar Registro Modulo Post
Route::patch ('/Posts/{post}', [PostController::class, 'update']);
//Consultar el registro
Route::get('/Posts/{id}/edit',[PostController::class,'show']);
//Eliminar registro
Route::delete('/Posts/{id}',[PostController::class,'destroy']);