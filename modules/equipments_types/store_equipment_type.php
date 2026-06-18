<?php

require_once '../../middleware/auth.php';
require_once 'EquipmentTypeController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;
}

try {

    $type = strtoupper(
        trim($_POST['equipment_type'])
    );

    if (empty($type)) {

        throw new Exception(
            'Tipo inválido.'
        );
    }

    if (
        equipmentTypeExists(
            $conexion,
            $type
        )
    ) {

        throw new Exception(
            'El tipo ya existe.'
        );
    }

    createEquipmentType(
        $conexion,
        $type
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error store_equipment_type: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al guardar el tipo.'
    );
}