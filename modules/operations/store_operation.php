<?php

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $name = strtoupper($name);

    $site = $_POST['site'];
    $business = $_POST['business'];

    try{

        $sql = "SELECT * FROM operations
                WHERE name = :name";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $operation = $stmt->fetch();

        if($operation) {
            echo "El Negocio ya existe";
            exit();
        }

        $sql = "INSERT INTO operations (name, site_id, businesses_id )
                VALUES (:name, :site, :business)";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name,);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':business', $business);
        $stmt->execute();

        header('Location: ../../views/settings/settings.php');

        exit();
    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
}

?>
