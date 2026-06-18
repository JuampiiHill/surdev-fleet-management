<?php

require_once '../../config/database.php';

try {

    /* SITES */

    $sql_sites = "
        SELECT *
        FROM sites
        ORDER BY name ASC
    ";

    $stmt_sites = $conexion->prepare($sql_sites);
    $stmt_sites->execute();

    $sites = $stmt_sites->fetchAll();

    /* OPERACIONES */

    $sql_operations = "
        SELECT *
        FROM operations
        ORDER BY name ASC
    ";

    $stmt_operations = $conexion->prepare($sql_operations);
    $stmt_operations->execute();

    $operations = $stmt_operations->fetchAll();

    /* NEGOCIOS */

    $sql_business = "
        SELECT *
        FROM businesses
        ORDER BY name ASC
    ";

    $stmt_business = $conexion->prepare($sql_business);
    $stmt_business->execute();

    $business = $stmt_business->fetchAll();

    /* PROVEEDORES */

    $sql_providers = "
        SELECT *
        FROM providers
        ORDER BY name ASC
    ";

    $stmt_provider = $conexion->prepare($sql_providers);
    $stmt_provider->execute();

    $providers = $stmt_provider->fetchAll();

    /* TIPOS DE EQUIPOS */

    $sql_equipment_types = "
        SELECT *
        FROM equipments_types
        ORDER BY type ASC
    ";

    $stmt_equipment_types =
        $conexion->prepare($sql_equipment_types);

    $stmt_equipment_types->execute();

    $equipment_types =
        $stmt_equipment_types->fetchAll();

    /* ESTADOS DE EQUIPOS */

    $sql_statuses = "
        SELECT *
        FROM equipment_statuses
        ORDER BY name ASC
    ";

    $stmt_statuses =
        $conexion->prepare($sql_statuses);

    $stmt_statuses->execute();

    $statuses =
        $stmt_statuses->fetchAll();

} catch (PDOException $e) {

    error_log(
        'Error SettingsController: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar las configuraciones.'
    );
}