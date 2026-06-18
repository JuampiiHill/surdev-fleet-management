<?php

require_once '../../middleware/auth.php';
require_once 'OperationController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;
}

try {

    $name = strtoupper(
        trim($_POST['name'])
    );

    $site_id = (int) $_POST['site'];
    $business_id = (int) $_POST['business'];

    if (
        empty($name) ||
        $site_id <= 0 ||
        $business_id <= 0
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    if (
        operationExists(
            $conexion,
            $name
        )
    ) {

        throw new Exception(
            'La operación ya existe.'
        );
    }

    createOperation(
        $conexion,
        $name,
        $site_id,
        $business_id
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error store_operation: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al guardar la operación.'
    );
}