<?php

require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['site']);

    $name = strtoupper($name);

    try{

        $sql = "SELECT * FROM sites
                WHERE name = :name";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $site = $stmt->fetch();

        if($site) {
            echo "El Site ya existe";
            exit();
        }

        $sql = "INSERT INTO sites (name)
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
