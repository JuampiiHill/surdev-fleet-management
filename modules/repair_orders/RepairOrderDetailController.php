<?php

require_once '../../config/database.php';

/* VALIDAR ID  */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header('Location: ../../views/dashboard/dashboard.php');
    exit;
}

$repair_order_id = (int) $_GET['id'];

try {

    /* OBTENER OR  */

    $sql = "

        SELECT

            ro.*,

            e.internal_number,
            e.brand,
            e.model

        FROM repair_orders ro

        INNER JOIN equipments e
            ON ro.equipment_id = e.id

        WHERE ro.id = :id

    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $repair_order_id
    ]);

    $repair_order = $stmt->fetch();

    if (!$repair_order) {

        header('Location: ../../views/dashboard/dashboard.php');
        exit;
    }

    /* WORK ORDERS  */

    $sql_work_orders = "

        SELECT *
        FROM repair_work_orders

        WHERE repair_order_id = :repair_order_id

        ORDER BY work_date ASC,
                 id ASC

    ";

    $stmt_work_orders =
        $conexion->prepare($sql_work_orders);

    $stmt_work_orders->execute([
        ':repair_order_id' => $repair_order_id
    ]);

    $work_orders =
        $stmt_work_orders->fetchAll();

    /* PRESUPUESTOS  */

    $sql_quotes = "

        SELECT *
        FROM repair_quotes

        WHERE repair_order_id = :repair_order_id

        ORDER BY quote_date DESC

    ";

    $stmt_quotes =
        $conexion->prepare($sql_quotes);

    $stmt_quotes->execute([
        ':repair_order_id' => $repair_order_id
    ]);

    $quotes =
        $stmt_quotes->fetchAll();

    /* FACTURAS  */

    $sql_invoices = "

        SELECT *
        FROM repair_invoices

        WHERE repair_order_id = :repair_order_id

        ORDER BY invoice_date DESC

    ";

    $stmt_invoices =
        $conexion->prepare($sql_invoices);

    $stmt_invoices->execute([
        ':repair_order_id' => $repair_order_id
    ]);

    $invoices =
        $stmt_invoices->fetchAll();

} catch (PDOException $e) {

    error_log(
        'Error RepairOrderDetailController: '
        . $e->getMessage()
    );

    die('Ocurrió un error al cargar la orden de reparación.');
}