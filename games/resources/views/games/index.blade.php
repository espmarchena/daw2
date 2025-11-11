<h1> Mis jueguecitos </h1>

{{-- una arroba por cada instruccion php --}}
@if ($games->isEmpty())
    <p> No hay juegos para mostrar </p>
@else
    <ul>
        @foreach($games as $game) {{--  estructura: $nombredelarray 'as' $llamarlocomoquieras, normalmente como el array pero en singular porque coge un juego en cada vuelta --}}
        <li>
            {{ $game->name}} : {{ $game->price}} {{-- $game es cada juego que se va a ir mostrando en el bucle, y le asociamos el nombre y el precio --}}
            <a href="{{ route('games.edit', $game->id) }}"> {{-- el metodo route crea la url que toque, le indicamos que añada el id como variable  --}}
                (Editar) </a>

            <form action="{{ route('games.destroy', $game->id) }}" method="POST" style="display:inline;"> {{-- el estilo lo usamos para que la caja del boton borrar se ponga al lado y no abajo --}}
                @csrf {{-- los formularios x seguridad se cifran, esto mete un token unico--}}

                @method('DELETE') {{-- --}}

                <button type= "submit"> Borrar</button>

            </form>

        </li>
        @endforeach
    </ul>
@endif