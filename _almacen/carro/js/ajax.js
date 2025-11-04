function cargarContenido(url, capadestino) { // parametros: url a la que ajax envia los datos, y lugar donde tiene que colocar los datos que recibe (en check.php capadestino es carro)
    var ajax = NuevoAjax(); 
    ajax.open("GET", url, true); // metodo .open abre el canal get con la url que le damos para ENVIAR lo datos
    
    ajax.onreadystatechange = function() { // evento que va comprobando el cambio del estado de la respuesta
        if (ajax.readyState == 4 && ajax.status == 200) { // codigos de estado, 4-> la petición ha completado su ciclo, 200 -> la respuesta del servidor fue exitosa
            if(capadestino != '') {
            var contenedor = document.getElementById(capadestino); // variable donde se va a inyectar el resultado
            contenedor.innerHTML = ajax.responseText; // tal como viene el contenido de lo que recibimos, lo inyectamos en el contenedor del html
            }                           // metodo .respondeText RECIBE los datos
           //alert(ajax.responseText); // muestra los datos que vienen del servidor (es para depurar, si es un error de php me va a salir)
        }                           
    };
    ajax.send(null); // envia datos
}


// cómo se activan los componentes
function NuevoAjax(){
    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }

    if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}