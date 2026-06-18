<?php

session_start();

require_once '../../middleware/auth.php';
require_once 'CostController.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }

    $equipment_id =
        (int) $_POST['equipment_id'];

    $cost_date =
        $_POST['cost_date'];

    $cost_type =
        trim($_POST['cost_type']);

    $description =
        trim(
            $_POST['description']
        );

    $amount =
        (float) $_POST['amount'];

    if (
        $equipment_id <= 0 ||
        empty($cost_date) ||
        empty($cost_type) ||
        $amount <= 0
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    $allowed_types = [
        'HORAS_EXTRAS',
        'TRASLADO',
        'RECUPERO',
        'OTROS'
    ];

    if (
        !in_array(
            $cost_type,
            $allowed_types
        )
    ) {

        throw new Exception(
            'Tipo de costo inválido.'
        );
    }

    $file_name =
        uploadCostFile(
            $_FILES['file'] ?? []
        );

    $result = createCost(
        $conexion,
        $equipment_id,
        $cost_date,
        $cost_type,
        $description,
        $amount,
        $file_name
    );

    if (!$result) {

        throw new Exception(
            'No se pudo registrar el costo.'
        );
    }

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
        $equipment_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error create_cost: ' .
        $e->getMessage()
    );

    die(
        'Ocurrió un error al registrar el costo.'
    );
}