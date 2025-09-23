<?php
session_start(); //para poder cerrar una sesion primero hay que abrirla

include('inc_libreria.php'); //cargamos otro archivo php justo en esta linea del codigo

cerrarSesion();

if(!empty($_GET['redire'])){ //controla si redirecciona. Si no esta vacia la variable, redirecciona 
	header('Location: '.$_GET['redire']); //redirecciona a una URL que viene por parámetro GET (pusimos adivina2.php)
}

