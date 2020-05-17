<?php

require_once __DIR__ . '/Pregunta.php';

$pregunta = new Pregunta();

header('Content-Type: application/json');
echo $pregunta->selectAll();