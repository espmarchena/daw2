<?php
include('config.php');
include('inc_libreria.php');

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
$sql = "SELECT * FROM categorias;";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$listadoCat = '<ul>';
while ($reg = $stmt->fetch()) {
    $listadoCat.= "<li>";
        $listadoCat.= "<img src='img/{$reg['foto']}' alt='Icono categoría i{$reg['categoria']}' width='50'>";
        $listadoCat.= "<a href='compras.php?idcat={$reg['id']}'>{$reg['categoria']}</a>";
    $listadoCat.= "</li>";
}
$listadoCat.= '</ul>';


$listadoProductos = '';
if(!empty($_GET['idcat'])){
    $sqlProd = "SELECT * FROM productos WHERE categoria_id = :idcat";
    $stmtProd = $conexion->prepare($sqlProd);
    $stmtProd->bindParam(':idcat',$_GET['idcat'],PDO::PARAM_INT);
    $stmtProd->execute();
    while($regProd = $stmtProd->fetch()){
        $listadoProductos.= "<div class='caja_item'>"; // Caja para cada producto
            $listadoProductos.= "<div class='marco'><img src='img/{$regProd['foto']}' alt='{$regProd['producto']}'></div>";
            $listadoProductos.= "<div class='info'>{$regProd['producto']}</div>";
            $listadoProductos.= "<div class='bpalcarro' data-producto-id='{$regProd['id']}' data-accion='padentro'>Añadir</div>";
        $listadoProductos.= '</div>';
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <script src="js/ajax.js" type="text/javascript"></script>
    <link rel="STYLESHEET" type="text/css" href="css/estilos.css">
</head>
<body>
<header>
    <div id="info_usuario">
        Identificado como: <span class='nombre_usuario'><?=$_SESSION['usuario']?></span>
        <a  href="cerrar.php"><img src="img/salir.png" alt="Cerrar sesión" width="30"></a>
    </div>
</header>

<main>
    <section id="panel_categorias">
        <?=$listadoCat?>
    </section>
    <section id="panel_productos">
        <?=$listadoProductos?>
    </section>
    <section id="panel_carro">
        
    </section>
</main>


<script>
    document.addEventListener('DOMContentLoaded',function(){
        // Carga inicial del contenido del carro
        cargarContenido('carro.php','panel_carro');

        // Comportamiento de los botones de añadir o quitar producto del carro
        document.addEventListener('click', function(e) {
            if (e.target.getAttribute('data-producto-id')) {
                let idproducto = e.target.getAttribute('data-producto-id');
                let accion = e.target.getAttribute('data-accion');
                let url = `carro.php?idproducto=${idproducto}&accion=`+accion;
                let capadestino = 'panel_carro';

                cargarContenido(url,capadestino);
            }
        });

    });
</script>

</body>
</html>