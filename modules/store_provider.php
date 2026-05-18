<?php

require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['provider']);

    $name = strtoupper($name);

    try{

        $sql = "SELECT * FROM providers
                WHERE name = :name";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $providers = $stmt->fetch();

        if($providers) {
            echo "El Proveedor ya existe";
            exit();
        }

        $sql = "INSERT INTO providers (name)
                VALUES (:name)";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        header('Location: ../views/dashboard/dashboard.php');

        exit();
    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
}

?>
