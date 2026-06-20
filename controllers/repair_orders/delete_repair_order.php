<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }

    $id =
        (int) ($_POST['id'] ?? 0);

    $delete_reason =
        trim(
            $_POST['delete_reason']
            ?? ''
        );

    if (
        $id <= 0 ||
        empty($delete_reason)
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    $sql = "

        UPDATE repair_orders

        SET
            deleted_by = :deleted_by,
            deleted_at = NOW(),
            delete_reason = :delete_reason

        WHERE id = :id

    ";

    $stmt =
        $conexion->prepare($sql);

    $result =
        $stmt->execute([

            ':deleted_by' =>
                $_SESSION['user_id']
                ?? null,

            ':delete_reason' =>
                $delete_reason,

            ':id' =>
                $id

        ]);

    if (!$result) {

        throw new Exception(
            'No se pudo eliminar la OR.'
        );
    }

    header(
        'Location: ' .
        $_SERVER['HTTP_REFERER']
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error delete_repair_order: ' .
        $e->getMessage()
    );

    die(
        $e->getMessage()
    );
}