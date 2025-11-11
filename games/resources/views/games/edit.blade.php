<h1> Editar Juego {{ $game->name }}</h1>

<form action ="{{ route('games.update', $game->id) }}" method="POST"> {{-- la doble llave significa inyeccion de php(echo). Pasandole el id, sabe que juego es el que tiene que editar --}}

    @csrf {{-- los formularios x seguridad se cifran, esto mete un token unico--}}

    @method('PUT') {{-- metodo para actualizar los dastos (hay dos: put y patch). El put actualiza recursos completos--}}

    <div>
        <label> Nombre: </label>
        <input type= "text" name="name" value= "{{ $game->name }}"> {{-- en name ponemos el nombre que tiene en la bbdd y en el value le decimos qué valor coger --}}

        <label> Plataforma: </label>
        <input type= "text" name="platform" value= "{{ $game->platform }}"> {{-- en name ponemos el nombre que tiene en la bbdd y en el value le decimos qué valor coger --}}

        <label> Precio: </label>
        <input type= "number" name="price" value= "{{ $game->price }}"> {{-- en name ponemos el nombre que tiene en la bbdd y en el value le decimos qué valor coger --}}
    </div>

    <button type= "submit"> Guardar</button>

</form>