<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $equipment_id = (int) ($_POST['equipment_id'] ?? 0);
    $work_order_number = trim($_POST['work_order_number'] ?? '');
    $work_date = $_POST['work_date'] ?? '';
    $mechanic_name = trim($_POST['mechanic_name'] ?? '');
    $work_description = trim($_POST['work_description'] ?? '');

    if (
        $id <= 0 ||
        $equipment_id <= 0 ||
        empty($work_order_number) ||
        empty($work_date)
    ) {
        throw new Exception('Datos inválidos.');
    }

    $stmt_or = $conexion->prepare("
        SELECT
            ro.report_date
        FROM repair_work_orders rwo
        INNER JOIN repair_orders ro
            ON rwo.repair_order_id = ro.id
        WHERE rwo.id = :id
        AND rwo.deleted_at IS NULL
        AND ro.deleted_at IS NULL
    ");

    $stmt_or->execute([
        ':id' => $id
    ]);

    $repair_order =
        $stmt_or->fetch();

    if (!$repair_order) {
        throw new Exception('OT inexistente o asociada a una OR eliminada.');
    }

    if ($work_date < $repair_order['report_date']) {
        throw new Exception(
            'La fecha de la OT no puede ser anterior a la fecha de la OR.'
        );
    }

    $sql = "
        UPDATE repair_work_orders
        SET
            work_order_number = :work_order_number,
            work_date = :work_date,
            mechanic_name = :mechanic_name,
            work_description = :work_description,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':work_order_number' => $work_order_number,
        ':work_date' => $work_date,
        ':mechanic_name' => $mechanic_name,
        ':work_description' => $work_description,
        ':updated_by' => $_SESSION['user_id'] ?? null,
        ':id' => $id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar la OT.');
    }

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
        $equipment_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_work_order: ' .
        $e->getMessage()
    );

    die($e->getMessage());
}