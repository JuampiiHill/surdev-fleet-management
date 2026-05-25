<?php

    //---------ELIMINAR TIPO DE EQUIPOS (AUTOELEVADORES ETC.) ---------
require_once '../../config/database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM equipments_types
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('Location: ../../views/settings/settings.php');
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>