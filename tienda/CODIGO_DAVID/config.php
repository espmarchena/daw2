<?php
$servidor = 'mysql:host=localhost;dbname=prueba1;port=3306;charset=utf8;';
$usuariodb = 'yo';
$clavedb = '2_Patatas';
$opcionesDB = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
];