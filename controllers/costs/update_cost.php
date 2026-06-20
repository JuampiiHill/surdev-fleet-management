<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }

    $id =
        (int) ($_POST['id'] ?? 0);

    $equipment_id =
        (int) ($_POST['equipment_id'] ?? 0);

    $cost_date =
        $_POST['cost_date'] ?? '';

    $cost_type =
        trim($_POST['cost_type'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    $amount =
        (float) ($_POST['amount'] ?? 0);

    $allowed_types = [
        'HORAS_EXTRAS',
        'TRASLADO',
        'RECUPERO',
        'OTROS'
    ];

    if (
        $id <= 0 ||
        $equipment_id <= 0 ||
        empty($cost_date) ||
        !in_array($cost_type, $allowed_types) ||
        $amount <= 0
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    $sql = "
        UPDATE equipment_costs
        SET
            cost_date = :cost_date,
            cost_type = :cost_type,
            description = :description,
            amount = :amount,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND equipment_id = :equipment_id
        AND deleted_at IS NULL
    ";

    $stmt =
        $conexion->prepare($sql);

    $result =
        $stmt->execute([
            ':cost_date' => $cost_date,
            ':cost_type' => $cost_type,
            ':description' => $description,
            ':amount' => $amount,
            ':updated_by' => $_SESSION['user_id'] ?? null,
            ':id' => $id,
            ':equipment_id' => $equipment_id
        ]);

    if (!$result) {

        throw new Exception(
            'No se pudo actualizar el costo.'
        );
    }

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
        $equipment_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_cost: ' .
        $e->getMessage()
    );

    die(
        'Ocurrió un error al actualizar el costo.'
    );
}