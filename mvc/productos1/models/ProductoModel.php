<?php

require_once 'lib/BDD.php'; // require es como un include. El contenido del archivo que se le pasa es obligatorio pq no deja continuar si no lo encuentra, y además solo se carga una vez (sino puede machacar instancias ya creadas)

class ProductoModel{
    private $db;
    private $config;

    public function __construct(){ // sintaxis de los constructores en php
        $this->config = require ('config/database.php');
        $this->db = BDD::conectarse($this->config);
    }

}

