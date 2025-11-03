<?php

require_once 'lib/BDD.php'; // require es como un include. El contenido del archivo que se le pasa es obligatorio pq no deja continuar si no lo encuentra, y además solo se carga una vez (sino puede machacar instancias ya creadas)

class ProductoModel{
    private $db;
    private $config;

    public function __construct(){ // sintaxis de los constructores en php
        $this->config = require ('config/database.php');
        $this->db = BDD::conectarse($this->config); // conexion creada en la variable $db y que usaremos mas abajo para el stmt
    }

    public function getProductos(array $filtros = []): array
    { // función responsable de filtrar. Comprueba que lo que retorna es un array (devuelve un listado de productos en forma de array)
        $sqlFiltros = ''; // para la instrucción sql
        $parametros = []; // para el bindParam

        // si hay que filtrar por PRECIO
        if(!empty($filtros['precio']) && $filtros['precio']>0){
            $sqlFiltros .= ' AND precio > :precio'; 
            $parametros[':precio'] = $filtros['precio']; // a ese parametro le asignamos ese valor
        }

        // si hay que filtrar por NOMBRE_PRODUCTO
        if(!empty($filtros['nombre_producto'])){
            $sqlFiltros .= ' AND nombre_producto > :nombre_producto';
            $parametros[':nombre_producto'] = "%{$filtros['nombre_producto']}";
        }
        

        $sql = "SELECT * FROM productos2 WHERE 1 $sqlFiltros;";
        $stmt = $this-> db->prepare($sql);
        foreach($parametros as $key => &$valor){ // aspersan para declarar la variable valor para indicar que coja el valor que toca en el momento en el que se ejecute
            $stmt->bindParam($key, $valor);
        }
        $stmt->execute();

        return $stmt->fetchAll(); // fetchAll hace una matriz
    }

}

