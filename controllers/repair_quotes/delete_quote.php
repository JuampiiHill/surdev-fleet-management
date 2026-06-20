    <?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $repair_order_id = (int) ($_POST['repair_order_id'] ?? 0);
    $delete_reason = trim($_POST['delete_reason'] ?? '');

    if (
        $id <= 0 ||
        $repair_order_id <= 0 ||
        empty($delete_reason)
    ) {
        throw new Exception('Datos inválidos.');
    }

    $sql = "
        UPDATE repair_quotes
        SET
            deleted_by = :deleted_by,
            deleted_at = NOW(),
            delete_reason = :delete_reason
        WHERE id = :id
        AND repair_order_id = :repair_order_id
        AND deleted_at IS NULL
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':deleted_by' => $_SESSION['user_id'] ?? null,
        ':delete_reason' => $delete_reason,
        ':id' => $id,
        ':repair_order_id' => $repair_order_id
    ]);

    if (!$result) {
        throw new Exception('No se pudo eliminar el presupuesto.');
    }

    header(
        'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
        $repair_order_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error delete_quote: ' .
        $e->getMessage()
    );

    die('Ocurrió un error al eliminar el presupuesto.');
}