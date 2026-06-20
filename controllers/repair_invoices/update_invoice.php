<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $repair_order_id = (int) ($_POST['repair_order_id'] ?? 0);
    $invoice_number = trim($_POST['invoice_number'] ?? '');
    $invoice_date = $_POST['invoice_date'] ?? '';
    $amount = (float) ($_POST['amount'] ?? 0);

    if (
        $id <= 0 ||
        $repair_order_id <= 0 ||
        empty($invoice_number) ||
        empty($invoice_date) ||
        $amount <= 0
    ) {
        throw new Exception('Datos inválidos.');
    }

    $sql = "
        UPDATE repair_invoices
        SET
            invoice_number = :invoice_number,
            invoice_date = :invoice_date,
            amount = :amount,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND repair_order_id = :repair_order_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':invoice_number' => $invoice_number,
        ':invoice_date' => $invoice_date,
        ':amount' => $amount,
        ':updated_by' => $_SESSION['user_id'] ?? null,
        ':id' => $id,
        ':repair_order_id' => $repair_order_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar la factura.');
    }

    header(
        'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
        $repair_order_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_invoice: ' .
        $e->getMessage()
    );

    die('Ocurrió un error al actualizar la factura.');
}