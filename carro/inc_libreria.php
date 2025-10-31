<?php
session_start(); //iniciamos la sesión para poder acceder a las variables de sesión para comprobar que el usuario está identificado. Crea una cookie en el navegador del usuario

//VARIABLES DEL CODIGO, SIEMPRE ARRIBA TODAS JUNTAS, SINO SE PIERDEN
$mensajes = array('Identificación incorrecta', 'Acceso no autorizado'); //array que contiene los mensajes de error



//control de acceso que se aplica solo en la pagina que quiero (las que no tienen la variable $nocontroles definida)
if(!isset($nocontroles) && empty($_SESSION['nombre'])){ //si la variable nocontroles no está definida en el archivo (no existe) y la variable de sesión nombre está vacía, el usuario no está identificado y no puede acceder a la página
    noentra(true, 1); //llamamos a la función noentra para que redireccione al index.php con el mensaje de error 1 (acceso no autorizado)
    exit;  //por si falla la redirección
}

function cerrarSesion(){
	session_unset(); //borra las variables que estan en memoria
	session_destroy(); //destruye la sesion
}

function conectarse($servidor,$usuariodb,$clavedb,$opcionesDB){ //funcion para conectar a la base de datos
	try{ //PDO es la clase por la cual se hace la conexion a la base de datos
		$conectado = new PDO($servidor,$usuariodb,$clavedb,$opcionesDB); //crea un objeto PDO para conectar a la base de datos
	}catch(PDOException $excep){
		echo 'Ande va tú con la tajá vinagre, no pillo datos, cabesa: '.$excep->getMessage(); //lanza un error si no conecta
		exit;
	}
	return $conectado; //devuelve el objeto PDO
}

function noentra($patras, $tipodeerror){
	global $mensajes; //hacemos global el array de mensajes. No lo hacemos con datos sensibles
	if($patras){ //si es true, vuelve al index.php
		header('Location: index.php?msg='.$mensajes[$tipodeerror]); //redirecciona al index.php con el mensaje de error en la url
		exit; //por si falla la redirección
	}
}
