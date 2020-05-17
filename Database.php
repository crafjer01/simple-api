<?php

class Database
{
    public function connect()
    {
        try {       
            return new PDO (
               "mysql:host=localhost;dbname=id13699007_solascriptura",
                'id13699007_solauser', '~0w6(]#qy#h=92Tf', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );  
        } catch(PDOException $e) {
            echo 'Error: hubo un error conectandose a la base de datos';
            die();
        }
    }

}