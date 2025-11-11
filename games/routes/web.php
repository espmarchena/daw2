<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome'); //devuelve una vista y la ejecuta
});

// si son rutas que apuntan a paginas que no necesitan un logueo se ponen aqui fuera
Route::get('/games',[GameController::class, 'index'])->name('games.index'); // primer parametro: ruta para nuestro listado de juegos. Segundo parametro: controlador de los juegos. Estos van siempre entre corchetes. Le estamos pasando el metodo index que hemos desarrollado en el controlador que le hemos pasado. En este caso hacer un listado
Route::get('/games/create',[GameController::class, 'create'])->name('games.create'); //la clase Route tiene un metodo llamado name, que le da un nombre a la ruta (un alias para utilizarla)
Route::post('/games',[GameController::class, 'store'])->name('games.store'); //al llegar el metodo store por metodo post, no hace falta ponerlo en la ruta
Route::get('/games/{id}/edit', [GameController::class, 'edit'])->name('games.edit'); // le pasamos el id del juego antes de la vista
Route::put('/games/{id}', [GameController::class, 'update'])->name('games.update'); //como en el post, no hace falta pasarle en la ruta la vista, el controlador se lo pasa

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); //->name le da un nombre a la ruta (un alias para utilizarla)

// si son rutas que apuntan a paginas que necesitan identificacion se ponen aqui dentro:
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
