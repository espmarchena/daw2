<?php
$servidor = 'mysql:host=localhost;dbname=prueba1;port=3306;charset=utf8;'; //almacena los datos de conexion a la base de datos
$usuariodb = 'emm';
$clavedb = 'Palomares@1011';
$opcionesDB = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //modo de error
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //modo de fetch
];

//PDO es la clase por la cual se hace la conexion a la base de datos