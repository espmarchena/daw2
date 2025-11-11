<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

// si son rutas que apuntan a paginas que no necesitan un logueo se ponen aqui fuera
Route::get('/games',[GameController::class, 'index']); // primer parametro: ruta para nuestro listado de juegos. Segundo parametro: controlador de los juegos. Estos van siempre entre corchetes. 

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); //->name le da un nombre a la ruta (un alias para utilizarla)


Route::middleware('auth')->group(function () { // si son rutas que apuntan a paginas que necesitan identificacion se ponen aqui dentro
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
