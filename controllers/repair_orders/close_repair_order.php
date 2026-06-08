<?php

session_start();

require_once '../../config/database.php';

$repair_order_id =
    $_POST['repair_order_id'];

$sql = "

    UPDATE repair_orders

    SET

        status = 'CERRADA',

        closed_date = CURDATE(),

        billable_charge = :billable_charge,

        estimated_cost = :estimated_cost,

        final_cost = :final_cost,

        invoice_date = :invoice_date,

        resolution_summary = :resolution_summary

    WHERE id = :id

";

$stmt = $conexion->prepare($sql);

$stmt->execute([

    ':billable_charge' =>
        isset($_POST['billable_charge']) ? 1 : 0,

    ':estimated_cost' =>
        $_POST['estimated_cost'] ?: null,

    ':final_cost' =>
        $_POST['final_cost'] ?: null,

    ':invoice_date' =>
        $_POST['invoice_date'] ?: null,

    ':resolution_summary' =>
        $_POST['resolution_summary'],

    ':id' =>
        $repair_order_id
]);

header(
    'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
    $repair_order_id
);

exit;