<?php

require_once '../../middleware/auth.php';
require_once 'BusinessController.php';

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

    if (empty($name)) {

        throw new Exception(
            'Nombre inválido.'
        );
    }

    if (
        businessExists(
            $conexion,
            $name
        )
    ) {

        throw new Exception(
            'El negocio ya existe.'
        );
    }

    createBusiness(
        $conexion,
        $name
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error store_business: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al guardar el negocio.'
    );
}
?>
