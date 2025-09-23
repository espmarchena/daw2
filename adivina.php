<?php

$mensaje="";
$visible = 'block';

if(empty($_POST['intentoactual'])){ //si no existe o esta vacio el campo intentoactual significa que debemos iniciar una nueva partida

	$adivina = rand(1,100); //pertenece a la clase math, y es para obtener a números aleatorios, entre los parentesis hay que decirle el intervalo de los numeros aleatorios que quiero que me de. Recordar que nunca va a llegar al tope, si quiero que incluya 100 hay que poner 101
	//echo $adivina; //cada vez que refresque la pagina me dará un numero aleatorio diferente
	$intentos = 1;
	$mensaje = "Adivina el número entre 1 y 100";
}

if(!empty($_POST['minumero'])){ //con empty comprobamos que exista y que ademas tiene que tener un valor asignado (no vacío)

	$adivina = $_POST['numerorandom']; //lo igualo para que coja la informacion del input

	if ($adivina == $_POST['minumero']){ //comprobamos si el usuario ha tecleado el numero correcto
		$mensaje = "adivinaste";
		$visible = 'none';
	}
	else if($adivina < $_POST['minumero']){
		$mensaje = "tu número es menor a ".$_POST['minumero'] ;
	}
	else{
		$mensaje = "tu número es mayor a ".$_POST['minumero'];
	}
	$intentos = $_POST['intentoactual']; //lo igualo para que coja la informacion del input
	$intentos++; //incrementamos en uno los intentos	

	if($intentos >10){
		$mensaje = "fin de la partida. Mi número era ". $adivina;
		$visible = 'none';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<p>Estamos en el intento número <?php echo $intentos ?></p>
<p><?php echo $mensaje; ?></p>

<div style="display:<?php echo $visible ?>;"> <!-- para manipular la visibilidad del form -->
	<form name="formu" id ="formu" method="POST" action="adivina.php">

		<input type="hidden" name="intentoactual" id="intentoactual" value="<?php echo $intentos ?>">  <!-- en este campo oculto, su valor, no se lo da nadie, se rellena solo a traves de lo que valga el contador $intentos. Lo usamos para que la aplicacion sepa si se ha iniciado ya la partida y controlar que no se recargue cada vez que pida un numero nuevo distinto-->
		<input type="hidden" name="numerorandom" id="numerorandom" value="<?php echo $adivina ?>"> <!-- para controlar cual es el mumero random e igualarlo a $adivina-->

		<input type="text" name="minumero" id="minumero"> <!-- para crear la caja en la que el usuario mete su numero -->
		<!-- el name es lo que vamos a usar para enviarle los datos al servidor -->

		<input type="submit" value="Adivinar"> <!-- para crear el boton de enviar el numero al servidor -->

	</form>
</div>

</body>
</html>