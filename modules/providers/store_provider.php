<?php

require_once '../../middleware/auth.php';
require_once 'ProviderController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: ../../views/settings/settings.php');
    exit;
}

try {

    $name = strtoupper(
        trim($_POST['provider'])
    );

    if (empty($name)) {

        throw new Exception(
            'Nombre inválido.'
        );
    }

    if (
        providerExists(
            $conexion,
            $name
        )
    ) {

        throw new Exception(
            'El proveedor ya existe.'
        );
    }

    createProvider(
        $conexion,
        $name
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error store_provider: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al guardar el proveedor.'
    );
}