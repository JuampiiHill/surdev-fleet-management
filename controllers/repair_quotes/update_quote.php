<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $repair_order_id = (int) ($_POST['repair_order_id'] ?? 0);
    $quote_number = trim($_POST['quote_number'] ?? '');
    $quote_date = $_POST['quote_date'] ?? '';
    $amount = (float) ($_POST['amount'] ?? 0);

    if (
        $id <= 0 ||
        $repair_order_id <= 0 ||
        empty($quote_number) ||
        empty($quote_date) ||
        $amount <= 0
    ) {
        throw new Exception('Datos inválidos.');
    }

    $sql = "
        UPDATE repair_quotes
        SET
            quote_number = :quote_number,
            quote_date = :quote_date,
            amount = :amount,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE id = :id
        AND repair_order_id = :repair_order_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':quote_number' => $quote_number,
        ':quote_date' => $quote_date,
        ':amount' => $amount,
        ':updated_by' => $_SESSION['user_id'] ?? null,
        ':id' => $id,
        ':repair_order_id' => $repair_order_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar el presupuesto.');
    }

    header(
        'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
        $repair_order_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_quote: ' .
        $e->getMessage()
    );

    die('Ocurrió un error al actualizar el presupuesto.');
}