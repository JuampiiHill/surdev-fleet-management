<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';
require_once '../../helpers/EquipmentHourmeterHelper.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }

    $equipment_id =
        (int) ($_POST['equipment_id'] ?? 0);

    $maintenance_date =
        $_POST['maintenance_date'] ?? '';

    $hourmeter =
        (float) ($_POST['hourmeter'] ?? 0);

    $observations =
        trim($_POST['observations'] ?? '');

    if (
        $equipment_id <= 0 ||
        empty($maintenance_date) ||
        $hourmeter < 0
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    $sql_equipment = "
        SELECT current_hourmeter
        FROM equipments
        WHERE id = :equipment_id
    ";

    $stmt_equipment =
        $conexion->prepare($sql_equipment);

    $stmt_equipment->execute([
        ':equipment_id' => $equipment_id
    ]);

    $equipment =
        $stmt_equipment->fetch();

    if (!$equipment) {

        throw new Exception(
            'Equipo inexistente.'
        );
    }

    $sql_last = "
        SELECT hourmeter
        FROM equipment_maintenances
        WHERE equipment_id = :equipment_id
        AND deleted_at IS NULL
        ORDER BY maintenance_date DESC, id DESC
        LIMIT 1
    ";

    $stmt_last =
        $conexion->prepare($sql_last);

    $stmt_last->execute([
        ':equipment_id' => $equipment_id
    ]);

    $last_maintenance =
        $stmt_last->fetch();

    if (
        $last_maintenance &&
        $hourmeter <= (float) $last_maintenance['hourmeter']
    ) {

        throw new Exception(
            'El horómetro debe ser mayor al del último mantenimiento registrado.'
        );
    }

    $file_name = null;

    if (
        isset($_FILES['file']) &&
        $_FILES['file']['error'] === 0
    ) {

        $extension =
            strtolower(
                pathinfo(
                    $_FILES['file']['name'],
                    PATHINFO_EXTENSION
                )
            );

        $allowed = [
            'pdf',
            'jpg',
            'jpeg',
            'png'
        ];

        if (!in_array($extension, $allowed)) {

            throw new Exception(
                'Formato de archivo no permitido.'
            );
        }

        $upload_dir =
            '../../assets/uploads/maintenances/';

        if (!is_dir($upload_dir)) {

            mkdir(
                $upload_dir,
                0755,
                true
            );
        }

        $file_name =
            uniqid('maintenance_') .
            '.' .
            $extension;

        if (
            !move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $upload_dir . $file_name
            )
        ) {

            throw new Exception(
                'No se pudo subir el archivo.'
            );
        }
    }

    $sql = "
        INSERT INTO equipment_maintenances
        (
            equipment_id,
            maintenance_date,
            hourmeter,
            file,
            observations
        )
        VALUES
        (
            :equipment_id,
            :maintenance_date,
            :hourmeter,
            :file,
            :observations
        )
    ";

    $stmt =
        $conexion->prepare($sql);

    $result =
        $stmt->execute([
            ':equipment_id' => $equipment_id,
            ':maintenance_date' => $maintenance_date,
            ':hourmeter' => $hourmeter,
            ':file' => $file_name,
            ':observations' => $observations
        ]);

    if (!$result) {

        throw new Exception(
            'No se pudo registrar el preventivo.'
        );
    }

    recalculateEquipmentHourmeter(
        $conexion,
        $equipment_id
    );

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' .
            $equipment_id
    );

    exit;
} catch (Exception $e) {

    error_log(
        'Error create_maintenance: ' .
            $e->getMessage()
    );

    die($e->getMessage());
}
