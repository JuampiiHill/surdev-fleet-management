<?php

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);

    $name = strtoupper($name);

    try{

        $sql = "SELECT * FROM businesses
                WHERE name = :name";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $businesses = $stmt->fetch();

        if($businesses) {
            echo "El Negocio ya existe";
            exit();
        }

        $sql = "INSERT INTO businesses (name)
                VALUES (:name)";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        header('Location: ../../views/settings/settings.php');

        exit();
    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
}

?>
