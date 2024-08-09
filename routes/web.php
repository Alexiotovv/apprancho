<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\PlanillasController;

Route::get('/',function(){
    return view('auth.login');
})->name('credentials');

//Home y Graficos
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');



//Trabajadores
Route::get('/trabajadores/index', [TrabajadoresController::class,'index'])->middleware(['auth'])->name('trabajadores.index');
Route::post('/trabajadores/store', [TrabajadoresController::class,'store'])->middleware(['auth'])->name('trabajadores.store');
Route::get('/trabajadores/edit/{id}', [TrabajadoresController::class,'edit'])->middleware(['auth'])->name('trabajadores.edit');
Route::post('/trabajadores/update', [TrabajadoresController::class,'update'])->middleware(['auth'])->name('trabajadores.update');
Route::post('/trabajadores/destroy', [TrabajadoresController::class,'destroy'])->middleware(['auth'])->name('trabajadores.destroy');


//EmpresasTrabajó
Route::get('/trabajadores/empresas/{id}', [TrabajadoresController::class,'empresas'])->middleware(['auth'])->name('trabajadores.empresas');
// Route::post('/trabajadores/empresas/store', [TrabajadoresController::class,'empresas_store'])->middleware(['auth'])->name('empresas_store');

//Planillas
Route::get('/planillas/index', [PlanillasController::class,'index'])->middleware(['auth'])->name('planillas.index');
Route::post('/planillas/store', [PlanillasController::class,'store'])->middleware(['auth'])->name('planillas.store');
Route::get('/planillas/show/{fecha}/{empresa}', [PlanillasController::class,'show'])->middleware(['auth'])->name('planillas.show');
Route::get('/planillas/checkcomida/{codido}/{comida}', [PlanillasController::class,'checkcomida'])->middleware(['auth'])->name('planillas.checkcomida');
Route::get('/planillas/checkestado/{id}/{comida}/{estado}', [PlanillasController::class,'checkestado'])->middleware(['auth'])->name('planillas.checkestado');
Route::get('/planillas/ticket/index', [PlanillasController::class,'ticket_index'])->middleware(['auth'])->name('planillas.ticket.index');
Route::post('/planillas/ticket/', [PlanillasController::class,'ticket'])->middleware(['auth'])->name('planillas.ticket');

//Empresas
Route::get('/empresas/index', [EmpresasController::class,'index'])->middleware(['auth'])->name('empresas.index');
Route::post('/empresas/store', [EmpresasController::class,'store'])->middleware(['auth'])->name('empresas.store');
Route::get('/empresas/edit/{id}', [EmpresasController::class,'edit'])->middleware(['auth'])->name('empresas.edit');
Route::post('/empresas/update', [EmpresasController::class,'update'])->middleware(['auth'])->name('empresas.update');
Route::post('/empresas/destroy', [EmpresasController::class,'destroy'])->middleware(['auth'])->name('empresas.destroy');


//Register and Login user
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Usuarios
Route::get('/users', [UserController::class,'users'])->middleware(['auth'])->name('users');
Route::get('/users/edit/{id}', [UserController::class,'edit'])->middleware(['auth'])->name('usuario.edit');
Route::get('/users/create', [UserController::class,'create'])->middleware(['auth'])->name('usuario.create');
Route::post('/users/update', [UserController::class,'update'])->middleware(['auth'])->name('usuario.update');
Route::post('/users/changepassword', [UserController::class,'changepassword'])->middleware(['auth'])->name('change.password');

Route::post('/profile', function () { return auth()->user(); });
Route::patch('/change_status/user/{id_user}', [UserController::class,'change_status']);
Route::post('/register', [UserController::class,'register'])->name('register');