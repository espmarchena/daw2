<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes VIP</title>
    <script src = "js/ajax.js" type="text/javascript"> </script> <!-- include de la libreria ajax.js -->
    <style>
        .botoncito{
            display: inline-block;  /* que se comporte como un enlace (etiqueta <a>) pero con propiedades de bloque */
            border: thin dashed rgb(255,170,0); /* borde punteado */
            background-color: rgb(255,255,140);
            padding: 5px; /* espacio interior */
        }
        .botoncito :hover { /* solo aplica a las etiquetas cuando pasas por encima, en reposo no funciona */
            cursor: pointer; /* para mostrar una manita al pasar por encima */
        }
    </style>
</head>
<body>

    <div> 
        <span class="botoncito" id="boton_1">
            <img src="img/ok.png" width="16" id="check">
            Mostrar VIPs
        </span>
    </div>

    <div> 
        <span class="botoncito" id="boton_0">
            <img src="img/nook.png" width="16" id="nocheck">
            Mostrar NO VIPs
        </span>
    </div>

    <div id= "listado"> </div> <!-- contenedor que se rellena con ajax -->
    
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            for (let i=0; i<2; i++){
                document.getElementById('boton_' + i).addEventListener('click',function(){ //cuando haga click en la imagen del vip
                    let url = 'damelistado.php?tipo='+i; //concatenamos con el id del get. estado es 0(desmarcado) ó 1 (marcado)
                    cargarContenido(url, 'listado'); //espera recibir la url a donde enviar la peticion, y nombre del contenedor del resultado
                });
            }
        });

    </script>
</body>
</html>
