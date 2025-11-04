<?php
$servidor = 'mysql:host=localhost;dbname=citaprevia;port=3306;charset=utf8;'; //almacena los datos de conexion a la base de datos
$usuariodb = 'emm';
$clavedb = 'Palomares@1011';
$opcionesDB = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //modo de error
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //modo de fetch que significa que devuelve un array asociativo
];

//PDO es la clase por la cual se hace la conexion a la base de datos