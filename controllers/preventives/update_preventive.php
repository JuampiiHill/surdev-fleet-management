<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';
require_once '../../helpers/EquipmentHourmeterHelper.php';
try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $equipment_id = (int) ($_POST['equipment_id'] ?? 0);
    $maintenance_date = $_POST['maintenance_date'] ?? '';
    $hourmeter = (float) ($_POST['hourmeter'] ?? 0);
    $observations = trim($_POST['observations'] ?? '');

    if (
        $id <= 0 ||
        $equipment_id <= 0 ||
        empty($maintenance_date) ||
        $hourmeter < 0
    ) {
        throw new Exception('Datos inválidos.');
    }

    $stmt_equipment = $conexion->prepare("
        SELECT current_hourmeter
        FROM equipments
        WHERE id = :equipment_id
    ");

    $stmt_equipment->execute([
        ':equipment_id' => $equipment_id
    ]);

    $current_hourmeter = $stmt_equipment->fetchColumn();

    if ($current_hourmeter === false) {
        throw new Exception('Equipo inexistente.');
    }

    $current_hourmeter = (float) $current_hourmeter;


    $stmt_previous = $conexion->prepare("
        SELECT MAX(hourmeter)
        FROM equipment_maintenances
        WHERE equipment_id = :equipment_id
        AND id <> :id
        AND deleted_at IS NULL
        AND maintenance_date <= :maintenance_date
    ");

    $stmt_previous->execute([
        ':equipment_id' => $equipment_id,
        ':id' => $id,
        ':maintenance_date' => $maintenance_date
    ]);

    $previous_hourmeter = $stmt_previous->fetchColumn();

    if (
        $previous_hourmeter !== null &&
        $previous_hourmeter !== false &&
        $hourmeter <= (float) $previous_hourmeter
    ) {
        throw new Exception(
            'El horómetro debe ser mayor al preventivo anterior registrado.'
        );
    }

    $stmt_next = $conexion->prepare("
        SELECT MIN(hourmeter)
        FROM equipment_maintenances
        WHERE equipment_id = :equipment_id
        AND id <> :id
        AND deleted_at IS NULL
        AND maintenance_date >= :maintenance_date
    ");

    $stmt_next->execute([
        ':equipment_id' => $equipment_id,
        ':id' => $id,
        ':maintenance_date' => $maintenance_date
    ]);

    $next_hourmeter = $stmt_next->fetchColumn();

    if (
        $next_hourmeter !== null &&
        $next_hourmeter !== false &&
        $hourmeter >= (float) $next_hourmeter
    ) {
        throw new Exception(
            'El horómetro debe ser menor al preventivo posterior registrado.'
        );
    }

    $sql = "
        UPDATE equipment_maintenances
        SET
            maintenance_date = :maintenance_date,
            hourmeter = :hourmeter,
            observations = :observations,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND equipment_id = :equipment_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':maintenance_date' => $maintenance_date,
        ':hourmeter' => $hourmeter,
        ':observations' => $observations,
        ':updated_by' => $_SESSION['user_id'] ?? null,
        ':id' => $id,
        ':equipment_id' => $equipment_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar el preventivo.');
    }

    recalculateEquipmentHourmeter(
        $conexion,
        $equipment_id
    );

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
            $equipment_id
    );


    exit;
} catch (Exception $e) {

    error_log(
        'Error update_preventive: ' .
            $e->getMessage()
    );

    die($e->getMessage());
}
