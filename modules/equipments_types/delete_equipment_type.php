<?php

require_once '../../middleware/auth.php';
require_once 'EquipmentTypeController.php';

try {

    if (!isset($_GET['id'])) {

        header(
            'Location: ../../views/settings/settings.php'
        );

        exit;
    }

    $id = (int) $_GET['id'];

    if ($id <= 0) {

        throw new Exception(
            'ID inválido.'
        );
    }

    deleteEquipmentType(
        $conexion,
        $id
    );

    header(
        'Location: ../../views/settings/settings.php'
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error delete_equipment_type: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al eliminar el tipo.'
    );
}