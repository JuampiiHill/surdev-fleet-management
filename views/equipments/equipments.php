<?php

session_strt();

require_once 'config/database.php';

$sql = "SELECT equipments.*, equipment_types.type, providers.name AS provider_name
        FROM equipments
        INNER JOIN equipment_types
        ON equipments.id_equipment_type = equipment_type.id
        INNER JOIN providers
        ON equipments.id_provider = providers.id"

$stmt = $conexion->prepare($sql);
$stmt->execute()

$equipments = $stmt->fetch();

if(!$equipments) {
    echo "No se encontraron equipos";
    header('Location: dashboard.php')
}

?>