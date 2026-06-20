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
    $delete_reason = trim($_POST['delete_reason'] ?? '');

    if (
        $id <= 0 ||
        $equipment_id <= 0 ||
        empty($delete_reason)
    ) {
        throw new Exception('Datos inválidos.');
    }

    $sql = "
        UPDATE equipment_maintenances
        SET
            deleted_by = :deleted_by,
            deleted_at = NOW(),
            delete_reason = :delete_reason
        WHERE id = :id
        AND equipment_id = :equipment_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':deleted_by' => $_SESSION['user_id'] ?? null,
        ':delete_reason' => $delete_reason,
        ':id' => $id,
        ':equipment_id' => $equipment_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo eliminar el preventivo.');
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
        'Error delete_preventive: ' .
        $e->getMessage()
    );

    die('Ocurrió un error al eliminar el preventivo.');
}