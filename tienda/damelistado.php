<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

//ESTA PAGINA SIEMPRE VA A NECESITAR CONEXION A LA BASE DE DATOS PORQUE ES LA QUE GENERA EL LISTADO DE PRODUCTOS
$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos


//PARA LISTAR LOS CLIENTES 
$sql = "SELECT * FROM clientes WHERE vip = :vip;"; //consulta SQL para seleccionar todos los clientes
$stmt = $conexion->prepare($sql); //prepara la consulta
$stmt->bindParam(':vip', $_GET['tipo'], PDO::PARAM_INT); //metodo que asocia el valor de la variable 'tipo' que llega por get al marcador :vip en la consulta SQL
$stmt->execute(); //metodo que ejecuta la consulta


//RECORRER LOS RESULTADOS DE LA CONSULTA Y CREAR EL LISTADO DE CLIENTES
$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $imagenVip = '<img src="img/nook.png" width = "16">';
    if($registro['vip']==1){
        $imagenVip = '<img src = "img/ok.png" width= "16">';
    }
    $listado .= '<li>';
        $listado.= $registro['nombre'].' '.$registro['apellido1'].' '.$registro['apellido2'];
        $listado .= '<span class="botoncito" id= "imgvip_'.$registro['id'].'">'.$imagenVip.'</span>';
    $listado .= '</li>';
}
echo $listado;

