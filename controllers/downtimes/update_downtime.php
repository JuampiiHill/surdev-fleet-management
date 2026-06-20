<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $equipment_id = (int) ($_POST['equipment_id'] ?? 0);
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    $manual_discount =
        ($_POST['manual_discount'] ?? '') !== ''
            ? (float) $_POST['manual_discount']
            : null;

    $reason = trim($_POST['reason'] ?? '');

    if (
        $id <= 0 ||
        $equipment_id <= 0 ||
        empty($start_date) ||
        empty($end_date) ||
        empty($reason)
    ) {
        throw new Exception('Datos inválidos.');
    }

    if (strtotime($end_date) < strtotime($start_date)) {
        throw new Exception('La fecha hasta no puede ser menor a la fecha desde.');
    }

    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    $days = $start->diff($end)->days + 1;

    $stmt_equipment = $conexion->prepare("
        SELECT monthly_cost
        FROM equipments
        WHERE id = :equipment_id
    ");

    $stmt_equipment->execute([
        ':equipment_id' => $equipment_id
    ]);

    $monthly_cost = (float) $stmt_equipment->fetchColumn();

    $calculated_discount = round(
        ($monthly_cost / 30) * $days,
        2
    );

    $sql = "
        UPDATE equipment_downtimes
        SET
            start_date = :start_date,
            end_date = :end_date,
            days = :days,
            monthly_rate = :monthly_rate,
            calculated_discount = :calculated_discount,
            manual_discount = :manual_discount,
            reason = :reason,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND equipment_id = :equipment_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':days' => $days,
        ':monthly_rate' => $monthly_cost,
        ':calculated_discount' => $calculated_discount,
        ':manual_discount' => $manual_discount,
        ':reason' => $reason,
        ':updated_by' => $_SESSION['user_id'] ?? null,
        ':id' => $id,
        ':equipment_id' => $equipment_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar la indisponibilidad.');
    }

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
        $equipment_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_downtime: ' .
        $e->getMessage()
    );

    die('Ocurrió un error al actualizar la indisponibilidad.');
}