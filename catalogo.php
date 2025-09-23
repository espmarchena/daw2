<?php

	session_start(); // si no lo ponemos, la pag no puede acceder al inicio de sesion

	if(!isset ($_SESSION['usuario'])){ // si no existe la sesion 
		header('Location: index.php'); // redirecciona al navegador a otra página inmediatamente
	}

	$titular='título de mi página';
	$numeros=''; //variable tipo String vacía
	$numeros_li=''; //variable tipo String vacía para modo lista
	$numeros_tbl=''; //variable tipo String vacía para modo tabla

	//$imagenes= array('','','',''); declaro array y le añado elementos del tirón
	$imagenes= array(); //declaro array vacío
	$imagenes[]= 'https://cdn.pixabay.com/photo/2013/07/04/13/24/clouds-143152_640.jpg'; //añado elementos al array
	$imagenes[]= 'https://cdn.pixabay.com/photo/2013/11/05/12/27/sea-205717_640.jpg';
	$imagenes[]= 'https://cdn.pixabay.com/photo/2023/01/07/14/49/sunset-7703422_640.jpg';
	$imagenes[]= 'https://cdn.pixabay.com/photo/2014/09/17/18/59/clouds-449822_640.jpg';


	for($i=0; $i<=3; $i++){ //bucle para aumentar el contador hasta 10
		$numeros .= '<br>'.$i; // concateno cada número

		$numeros_li .= "<li>$i</li>"; // concateno cada número en un elemento de lista
		//$numeros_li .= '<li>'.$i.'</li>'; //concatenado menos pŕactico

		$numeros_tbl .= '<tr><td><a href="detalles.php?im='.$i.'">'.$i.'</a></td><td><img src="'.$imagenes[$i].'" width="200"></td></tr>'; // concateno cada número y cada imagem en un elemento de fila. Ademas le doy un enlace a cada numero indicandole de que archivo coger la imagen
	}
?>

<html>
<head>
	<title><?php echo $titular ?></title>
	<style>
		.container{
			display: inline-flex;
			width: 30%;
		}
	</style>	
</head>
<body>

	<h1><?php echo $titular; ?></h1>
	<div>
		<div class= "container">
			<?php echo $numeros; ?>
		</div>
		<div class= "container">
			<ul>
				<?php echo $numeros_li; ?>
			</ul>	
		</div>
		<div class= "container">
			<table border = "1"> <!-- estilo para que se vean las lineas de la tabla -->			
				<?php echo $numeros_tbl; ?>			
			</table>	
		</div>

	</div>

</body>
</html>