<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; 

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();

        //dd($games);
        return view('games.index',['games'=>$games]); // devuelve la vista y le va a enviar el array games **clave=>valor**
    }              // vamos a mostrar un listado de los juegos

    public function create()
    {
        return view('games.create'); //devuelve una vista. Solo tiene un parametro pq esta vista no necesita datos, solo cargarse
    }

    public function store(Request $request) /* store utiliza un objeto tipo Request, que gestiona la recepcion de datos por metodos get y post. En $request los almacena para poder gestionarlos */
    {
        dd($request->all());
        return view('games.store'); //devuelve una vista. Solo tiene un parametro pq esta vista no necesita datos, solo cargarse
    }
}
