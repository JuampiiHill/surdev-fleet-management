<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id =
        (int) ($_POST['id'] ?? 0);

    $report_date =
        $_POST['report_date'] ?? '';

    $reported_by =
        trim($_POST['reported_by'] ?? '');

    $priority =
        $_POST['priority'] ?? '';

    $status =
        $_POST['status'] ?? '';

    $failure_description =
        trim($_POST['failure_description'] ?? '');

    $resolution_summary =
        trim($_POST['resolution_summary'] ?? '');

    $allowed_priorities = [
        'BAJA',
        'MEDIA',
        'ALTA'
    ];

    $allowed_statuses = [
        'ABIERTA',
        'EN PROCESO',
        'CERRADA'
    ];

    if (
        $id <= 0 ||
        empty($report_date) ||
        !in_array($priority, $allowed_priorities) ||
        !in_array($status, $allowed_statuses)
    ) {
        throw new Exception('Datos inválidos.');
    }

    $stmt_ot_count = $conexion->prepare("
        SELECT COUNT(*)
        FROM repair_work_orders
        WHERE repair_order_id = :repair_order_id
        AND deleted_at IS NULL
    ");

    $stmt_ot_count->execute([
        ':repair_order_id' => $id
    ]);

    $active_ot_count =
        (int) $stmt_ot_count->fetchColumn();

    if (
        $status === 'CERRADA' &&
        $active_ot_count === 0 &&
        empty($resolution_summary)
    ) {
        throw new Exception(
            'Para cerrar una OR sin OT asociada, debés completar el comentario de cierre.'
        );
    }

    $sql = "
        UPDATE repair_orders
        SET
            report_date = :report_date,
            reported_by = :reported_by,
            priority = :priority,
            status = :status,
            failure_description = :failure_description,
            resolution_summary = :resolution_summary,
            closed_date = CASE
                WHEN :status_closed = 'CERRADA' THEN COALESCE(closed_date, CURDATE())
                ELSE NULL
            END,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND deleted_at IS NULL
    ";

    $stmt =
        $conexion->prepare($sql);

    $result =
        $stmt->execute([
            ':report_date' => $report_date,
            ':reported_by' => $reported_by,
            ':priority' => $priority,
            ':status' => $status,
            ':failure_description' => $failure_description,
            ':resolution_summary' => $resolution_summary,
            ':status_closed' => $status,
            ':updated_by' => $_SESSION['user_id'] ?? null,
            ':id' => $id
        ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar la OR.');
    }

    header(
        'Location: ' . $_SERVER['HTTP_REFERER']
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_repair_order: ' .
        $e->getMessage()
    );

    die(
        $e->getMessage()
    );
}