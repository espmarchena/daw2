<h1> Añadir Nuevo Juego </h1>

<form action ="{{ route('games.store') }}" method="POST"> {{-- la doble llave significa inyeccion de php(echo) --}}
    @csrf {{-- los formularios x seguridad se cifran, esto mete un token unico--}}
    <div>
        <label> Nombre: </label>
        <input type= "text" name="name"> {{-- en name ponemos el nombre que tiene en la bbdd --}}

        <label> Plataforma: </label>
        <input type= "text" name="platform"> {{-- en name ponemos el nombre que tiene en la bbdd --}}

        <label> Precio: </label>
        <input type= "number" name="price"> {{-- en name ponemos el nombre que tiene en la bbdd --}}
    </div>

    <button type= "submit"> Guardar</button>

</form>