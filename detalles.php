<?php
$im= $_GET['im'];


$titular='';

$imagenes= array(); //declaro array vacío
$imagenes[]= 'https://cdn.pixabay.com/photo/2013/07/04/13/24/clouds-143152_640.jpg'; //añado elementos al array
$imagenes[]= 'https://cdn.pixabay.com/photo/2013/11/05/12/27/sea-205717_640.jpg';
$imagenes[]= 'https://cdn.pixabay.com/photo/2023/01/07/14/49/sunset-7703422_640.jpg';
$imagenes[]= 'https://cdn.pixabay.com/photo/2014/09/17/18/59/clouds-449822_640.jpg';

$infos[]= array();
$infos[]='nubes';
$infos[]='sol';
$infos[]='sol2';
$infos[]='mar';

$contenido = '<div><img src="'.$imagenes[$im].'" width="600"></div><div>'.$infos[$im].'</div>';

?>

<html>
<head>
	<title><?php echo $titular ?></title>
	<style>

		
	</style>	
</head>
<body>

	<h1><?php echo $titular; ?></h1>
	<div>
		<?php echo $contenido ?>			
	</div>

</body>
</html>