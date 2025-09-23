<?php

 for ($i=1; $i<=10; $i++){
 	//echo $i. '<br>'; //muestra del 1 al 10 hacia abajo

 	//echo ($i+10). '<br>'; // para poder sumarle 10 a la  variable i, hay que usar los parentesis sino casca porque no son del mismo tipo el br y los numeros (string e int)

 	//echo (($i+10)*3). '<br>'; //importantes los parentesis para las prioridades y el tipeo (int y string)

 	//echo ((($i+10)*3)%5). '<br>'; //importantes los parentesis para las prioridades y que no casque con el tipeo (int y string). Con esto tb averiguamos los multiplos de 5
 	
 	echo (((($i+10)*3)%5)**3). '<br>'; ///importantes los parentesis para las prioridades y que no casque con el tipeo (int y string). Exponenciado a 3

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

</body>
</html>