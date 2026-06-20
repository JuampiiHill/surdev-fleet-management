<?php

require_once '../../config/database.php';

try {

    $selected_status =
        $_GET['status'] ?? '';

    $selected_operation_id =
        isset($_GET['operation_id'])
            ? (int) $_GET['operation_id']
            : 0;

    $search =
        trim($_GET['search'] ?? '');

    $sql_operations = "
    SELECT DISTINCT
        o.id,
        o.name
    FROM operations o
    INNER JOIN equipments e
        ON e.operation_id = o.id
    INNER JOIN repair_orders ro
        ON ro.equipment_id = e.id
    WHERE ro.deleted_at IS NULL
    ORDER BY o.name ASC
";

    $stmt_operations =
        $conexion->prepare($sql_operations);

    $stmt_operations->execute();

    $operations =
        $stmt_operations->fetchAll();

    $sql_repair_orders = "
    SELECT
        ro.*,
        e.internal_number,
        e.brand,
        e.model,
        o.name AS operation_name,
        p.name AS provider_name,
        et.type AS equipment_type

    FROM repair_orders ro

    INNER JOIN equipments e
        ON ro.equipment_id = e.id

    LEFT JOIN operations o
        ON e.operation_id = o.id

    LEFT JOIN providers p
        ON e.provider_id = p.id

    LEFT JOIN equipments_types et
        ON e.equipment_type_id = et.id

    WHERE ro.deleted_at IS NULL
";

    $params = [];

    if (!empty($selected_status)) {

        $sql_repair_orders .= "
            AND ro.status = :status
        ";

        $params[':status'] =
            $selected_status;
    }

    if ($selected_operation_id > 0) {

        $sql_repair_orders .= "
            AND e.operation_id = :operation_id
        ";

        $params[':operation_id'] =
            $selected_operation_id;
    }

    if (!empty($search)) {

        $sql_repair_orders .= "
            AND (
                ro.order_number LIKE :search
                OR e.internal_number LIKE :search
                OR e.brand LIKE :search
                OR e.model LIKE :search
                OR ro.failure_description LIKE :search
            )
        ";

        $params[':search'] =
            '%' . $search . '%';
    }

    $sql_repair_orders .= "
        ORDER BY ro.report_date DESC, ro.id DESC
    ";

    $stmt_repair_orders =
        $conexion->prepare($sql_repair_orders);

    $stmt_repair_orders->execute($params);

    $repair_orders =
        $stmt_repair_orders->fetchAll();

} catch (PDOException $e) {

    error_log(
        'Error RepairOrdersController: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar las órdenes de reparación.'
    );
}