<?php

require_once __DIR__ . '/Database.php';


class Pregunta 
{
    protected $pdo;

    public function __construct()
    {
        try {       
            $this->pdo = new PDO (
               "mysql:host=localhost;dbname=id13699007_solascriptura",
                'id13699007_solauser', '~0w6(]#qy#h=92Tf', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );  
        } catch(PDOException $e) {
            echo 'Error: hubo un error conectandose a la base de datos';
            die();
        }
    }

    public function selectAll()
    {
       
        $statement = $this->pdo->prepare('select * from preguntas');
        $statement->execute();

        $preguntas = $statement->fetchAll(PDO::FETCH_ASSOC);


      $nuevaPreguntas = array_map(function($pregunta){

        $statement = $this->pdo->prepare('select * from respuestas where pregunta_id = ' . $pregunta['id']);
        $statement->execute();

        $respuestas = $statement->fetchAll(PDO::FETCH_ASSOC);

        $results =  [
            'id' => $pregunta['id'],
            'descripcion' => $pregunta['descripcion'],
            'cita' => $pregunta['cita'],
            'libro' => $pregunta['libro'],
            'cantidadSegundos' => 0,
            'cantidadSegundosResponder' => 0,
            'procesada' => false,
            'show' => false,
            'showRespuestaCorrecta' => false,
        ];

        //Buscar respuestas correcta
        foreach($respuestas as $respuesta) {
            if( $respuesta['es_correcta']) {
                $results['respuestaCorrecta'] = $respuesta['descripcion'];
            }
        }

        //buscar todas las respuestas
        $nuevaRespuestas = array_map(function($respuesta) {
                return [
                    'descripcion' => $respuesta['descripcion'],
                    'esCorrecta' => $respuesta['es_correcta'] ? true : false,
                    'show' => true
                ];
        }, $respuestas);
        $results['respuestas'] = $nuevaRespuestas;

        return $results;

      }, $preguntas);

        

        return json_encode($nuevaPreguntas);

    }

}