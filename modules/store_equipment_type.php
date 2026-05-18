<?php

require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['equipment_type']);

    $name = strtoupper($name);

    try {

        $sql = "SELECT * 
                FROM equipments_types
                WHERE type = :name";

        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        $type = $stmt->fetch();

        if($type) {

            echo "El tipo ya existe";

            exit();
        }

        $sql = "INSERT INTO equipments_types(type)
                VALUES(:name)";

        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        header('Location: ../views/settings/settings.php');

        exit();

    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
}
?>