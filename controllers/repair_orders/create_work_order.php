<?php

session_start();

require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $repair_order_id =
        (int) ($_POST['repair_order_id'] ?? 0);

    $mechanic_name =
        trim($_POST['mechanic_name'] ?? '');

    $work_date =
        $_POST['work_date'] ?? '';

    $work_description =
        trim($_POST['work_description'] ?? '');

    $work_order_number =
        trim($_POST['work_order_number'] ?? '');

    if (
        $repair_order_id <= 0 ||
        empty($work_date) ||
        empty($work_order_number)
    ) {
        throw new Exception('Datos inválidos.');
    }

    $stmt_or =
        $conexion->prepare("
            SELECT report_date
            FROM repair_orders
            WHERE id = :repair_order_id
            AND deleted_at IS NULL
        ");

    $stmt_or->execute([
        ':repair_order_id' => $repair_order_id
    ]);

    $repair_order =
        $stmt_or->fetch();

    if (!$repair_order) {
        throw new Exception('OR inexistente o eliminada.');
    }

    if ($work_date < $repair_order['report_date']) {
        throw new Exception(
            'La fecha de la OT no puede ser anterior a la fecha de la OR.'
        );
    }

    $file_name = null;

    if (
        isset($_FILES['file']) &&
        $_FILES['file']['error'] == 0
    ) {

        $file_name =
            time() . '_' .
            basename($_FILES['file']['name']);

        move_uploaded_file(
            $_FILES['file']['tmp_name'],
            '../../assets/uploads/repair_orders/' .
            $file_name
        );
    }

    $sql = "

        INSERT INTO repair_work_orders(

            repair_order_id,
            mechanic_name,
            work_date,
            work_description,
            work_order_number,
            file,
            created_by

        )
        VALUES(

            :repair_order_id,
            :mechanic_name,
            :work_date,
            :work_description,
            :work_order_number,
            :file,
            :created_by

        )

    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([

        ':repair_order_id' => $repair_order_id,
        ':mechanic_name' => $mechanic_name,
        ':work_date' => $work_date,
        ':work_description' => $work_description,
        ':work_order_number' => $work_order_number,
        ':file' => $file_name,
        ':created_by' => $_SESSION['user_id'] ?? null

    ]);

    $conexion->prepare("
        UPDATE repair_orders
        SET status = 'EN CURSO'
        WHERE id = ?
    ")->execute([$repair_order_id]);

    header(
        'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
        $repair_order_id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error create_work_order: ' .
        $e->getMessage()
    );

    die(
        $e->getMessage()
    );
}