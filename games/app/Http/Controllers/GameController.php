<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; 

class GameController extends Controller
{
    /* 
    📋 **INDEX - OPERACIÓN READ (Leer)**
    FUNCIÓN: Mostrar listado completo de juegos
    CRUD: READ (Lectura múltiple)
    */
    public function index()
    {
        $games = Game::all(); // Consulta TODOS los registros de la tabla games

        //dd($games);
        return view('games.index',['games'=>$games]); // devuelve la vista y le va a enviar el array games **clave=>valor**
    }              // vamos a mostrar un listado de los juegos

    /* 
    ➕ **CREATE - OPERACIÓN PRE-CREATE**
    FUNCIÓN: Mostrar formulario vacío para crear nuevo juego
    CRUD: PRE-CREATE (Preparación para crear)
    */
    public function create()
    {
        return view('games.create'); //devuelve una vista y la carga. Solo tiene un parametro pq esta vista no necesita datos, es un formulario vacio, solo cargarse
    }

    /* 
    💾 **STORE - OPERACIÓN CREATE (Crear)**
    FUNCIÓN: Procesar el formulario y GUARDAR nuevo juego en BD
    CRUD: CREATE (Crear nuevo registro)
    */
    public function store(Request $request) /* store utiliza un objeto tipo Request, que gestiona la recepcion de datos por metodos get y post. En $request los almacena para poder gestionarlos */
    {
        //dd($request->all());
        $request-> validate([ /* el metodo validate es para validar los datos, en este caso los que se han almacenado en $request */
            'name' => 'required | string | min:2',  //clave=>valor. Son reglas de validacion: que sea requerido, tipo string y minima longitud de dos caracteres
            'platform' => 'required | string', //clave=>valor. Son reglas de validacion: que sea requerido, tipo string
            'price' => 'required | numeric | min:0' //clave=>valor. Son reglas de validacion: que sea requerido, tipo string y minima longitud de cero caracteres
        ]); 

        $game = new Game; //creo una variable para crear una instancia de clase Game, para guardar en el modelo
        $game->name = $request->input('name'); //valores asignados
        $game->platform = $request->input('platform'); //valores asignados
        $game->price = $request->input('price'); //valores asignados
        $game->save(); // save guarda los datos que se han generado en la instancia del modelo Game. En este caso, hace un insert en la tabla game

        return redirect()->route('games.index'); // 
    }

    /* 
    ✏️ **EDIT - OPERACIÓN PRE-UPDATE**
    FUNCIÓN: Mostrar formulario RELLENO para editar juego existente
    CRUD: PRE-UPDATE (Preparación para actualizar)
    */
    public function edit($id) // necesita recibir el id del juego 
    {
        $game = Game::findOrFail($id); // busca un registro por su ID y si no lo encuentra, automáticamente lanza una excepcion 404

        return view('games.edit', compact('game')); // tiene dos parametro pq esta vista si necesita datos, tiene un formulario relleno. Parametro 1: la vista que carga, parametro 2: metodo que empaqueta en forma de array asociativo, y se le pasa el nombre del objeto
    }

    /* 
    🔄 **UPDATE - OPERACIÓN UPDATE (Actualizar)**
    FUNCIÓN: Procesar el formulario y ACTUALIZAR juego existente en BD
    CRUD: UPDATE (Actualizar registro existente)
    */
    public function update(Request $request, $id) //recibe los datos dados por get/post y el id del juego
    {
        $request-> validate([ /* el metodo validate es para validar los datos, en este caso los que se han almacenado en $request */
        'name' => 'required | string | min:2',  //clave=>valor. Son reglas de validacion: que sea requerido, tipo string y minima longitud de dos caracteres
        'platform' => 'required | string', //clave=>valor. Son reglas de validacion: que sea requerido, tipo string
        'price' => 'required | numeric | min:0' //clave=>valor. Son reglas de validacion: que sea requerido, tipo string y minima longitud de cero caracteres
        ]);

        $game = Game::findOrFail($id); // busca un registro por su ID y si no lo encuentra, automáticamente lanza una excepcion 404

        $game->name = $request->input('name'); //valores asignados
        $game->platform = $request->input('platform'); //valores asignados
        $game->price = $request->input('price'); //valores asignados
        $game->save(); // save guarda los datos que se han generado en la instancia del modelo Game. En este caso, hace un insert en la tabla game

        return redirect()->route('games.index'); //
    }

    public function destroy($id) // necesita recibir el id del juego 
    {
        $game = Game::findOrFail($id); // busca un registro por su ID y si no lo encuentra, automáticamente lanza una excepcion 404

        $game->delete(); // delete elimina los datos que se han generado en la instancia del modelo Game.

        return redirect()->route('games.index');
    }
}
