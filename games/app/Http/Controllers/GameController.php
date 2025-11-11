<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; 

class GameController extends Controller
{
    public function index(){
        $games = Game::all();

        //dd($games);
        return view('games.index',['games'=>$games]); // devuelve la vista y le va a enviar el array games **clave=>valor**
    }              // vamos a mostrar un listado de los juegos
}
