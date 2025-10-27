<?php

function cerrarSesion(){
	session_unset();
	session_destroy();
}

function conectarse($servidor,$usuariodb,$clavedb,$opcionesDB){
	try{
		$conectado = new PDO($servidor,$usuariodb,$clavedb,$opcionesDB);
	}catch(PDOException $e){
		echo 'Ande va tú con la tajá vinagre, no pillo datos, cabesa: '.$e->getMessage();
		exit;
	}
	return $conectado;
}