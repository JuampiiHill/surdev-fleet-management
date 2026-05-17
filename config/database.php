<?php

$host = "localhost";
$dbname = "surdev_db";
$user = "root";
$password = "";

try {
    // PDO = PHP Data Objetcts / Clase nativa de PHP que sirve para interactuar con la db
    $conexion = new PDO( // creamos una instancia de PDO
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    // con "->" se acceden a los metodos del OBJETO 
    // setAttribute metodo de la clase PDO sirve para configurar opciones del objeto conexion
    //PDO::ATTR_ERRMODE modo de manejo de errores / PDO::ERRMODE_EXCEPTION lanza una exepcion si ocurre un error
    // Los :: se usan para acceder a las consantes de la CLASE
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOExeption $e){
    echo "Error de conexion: " . $e->getMessage(); //obtiene el mensaje del error detallado
}

?>