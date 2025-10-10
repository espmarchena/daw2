<?php

session_start(); //iniciamos la sesión para poder acceder a las variables de sesión para comprobar que el usuario está identificado. Crea una cookie en el navegador del usuario


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

