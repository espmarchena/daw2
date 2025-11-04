<!-- datos de la conexion a la base de datos -->

<?php

return[
    'servidor' => 'mysql:host=localhost;dbname=prueba1;port=3306;charset=utf8;',
    'usuariodb' => 'emm',
    'clavebd' => 'Palomares@1011',
    'opcionesDB' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //modo de error
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, //modo de fetch que significa que devuelve un array asociativo
    ]
];
//PDO es la clase por la cual se hace la conexion a la base de datos