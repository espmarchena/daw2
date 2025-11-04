<?php

class BDD{
    public static function conectarse(array $config): PDO // función conectarse basada en la clase PDO
    {
        try{
            $conectado = new PDO(
                $config['servidor'],
                $config['usuariodb'],
                $config['clavedb'],
                $config['opcionesDB']
            );
        }
        catch (PDOException $excep){
		    echo 'No recibo datos: '.$excep->getMessage(); //lanza un error si no conecta
		    exit;
        }

        return $conectado;
    }
}