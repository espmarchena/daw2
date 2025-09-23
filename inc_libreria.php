<?php

function cerrarSesion(){
	session_unset(); //borra las variables que estan en memoria
	session_destroy(); //destruye la sesion
}
