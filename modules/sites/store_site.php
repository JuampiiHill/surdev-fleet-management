<?php

require_once '../../middleware/auth.php';
require_once 'SiteController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;
}

try {

    $name = strtoupper(
        trim($_POST['site'])
    );

    if (empty($name)) {

        throw new Exception(
            'Nombre inválido.'
        );
    }

    if (
        siteExists(
            $conexion,
            $name
        )
    ) {

        throw new Exception(
            'El site ya existe.'
        );
    }

    createSite(
        $conexion,
        $name
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error store_site: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al guardar el site.'
    );
}