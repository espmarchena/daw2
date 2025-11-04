<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{

        }
        .enfila{
            flex: 1;
        }
        #cesta{
            border-left: thin solid red;
            background-color: yellow;
        }
    </style>
</head>
<body>
    <div class ="enfila">
        <div data-item-tipo="fruta" data-item-id="11"> Mango </div> <!-- fruta es un atributo y Mango es su valor -->
        <div data-item-tipo="hortaliza" data-item-id="3"> Lechuga </div>
        <div>cualquiera</div>
        <div data-item-tipo="fruta" data-item-id="7"> Melón </div>
        <div data-item-tipo="legumbre" data-item-id="4"> Lentejas </div>
        <div>cualquiera</div>
    </div>

    <div class ="enfila" id ="cesta">


    </div>


    <script>

    document.addEventListener('DOMContentLoaded', function(){ // evento a capturar es que se cargue el contenido
        document.addEventListener('click', function(e){ // evento a capturar es hacer click ( es el desencadenante), y la 'e' es la variable que representa el evento, la cual vamos a manipular
            if(e.target.getAttribute('data-item-tipo')){ // e.target es el objeto sobre el cual se ha dado el evento
               //  alert(e.target.getAttribute('data-item-tipo')); // si tiene un atributo de ese tipo, alert me dice qué tipo de alimento es, devolviendome el valor que guarda este atributo
                lacesta = document.getElementById('cesta');
                lacesta.innerHTML+= "-" +e.target.innerHTML+"("+e.target.getAttribute('data-item-id')+")<br>"; // añade al contenido html del div llamado cesta el valor del texto/contentido del elemento que se clicó 


            }
        });
    });

    </script>
</body>
</html>