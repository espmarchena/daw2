<!-- esta pag cumprueba si tiene permiso para entrar y redirecciona al catalogo.php, sino tiene permiso vuelve a index.php, es un paso que el usuario no ve -->
<!-- si solo hay codigo php en el codigo, no se cierra la etiqueta. Es una mala practica hacerlo pq contiene codigo que se va a reutilizar en otras pags, y si ponemos etiqueta de cierre, cascaria la pag anfitrion donde pongamos esta pq la cerraria doblemente-->

<?php

session_start(); // comando que inicia la sesión para poder usar variables de sesión. Crea una cookie con el nombre de la sesion(un codigo, un token)

$usuario='emm';
$clave='1234';

$user= $_POST['user']; //obtiene el valor del campo "user" enviado desde un formulario HTML por el método POST.
$pwd= $_POST['pwd']; //obtiene el valor del campo "pwd" enviado desde un formulario HTML por el método POST.

if ($user == $usuario && $pwd == $clave){ //si el usuario del formulario coincide con el que hemos inicializado...
	$_SESSION['usuario'] = $user; // se pone aqui pq es la primera pag que necesita identificar al usuario
	header('Location:catalogo.php'); // header falsea las cabeceras y las envía al servidor. Con el header no puede haber un 'echo' ni nada que muestre x pantalla
}
else{ //si el usuario del formulario NO coincide con el que hemos inicializado...
	header('Location:index.php'); // redirecciona al navegador a otra página inmediatamente
};