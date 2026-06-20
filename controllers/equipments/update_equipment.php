<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../../views/dashboard/dashboard.php');
        exit;
    }

    $id = (int) $_POST['id'];

    $internal_number = trim($_POST['internal_number']);
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $year = !empty($_POST['year']) ? (int) $_POST['year'] : null;
    $serial_number = trim($_POST['serial_number']);
    $equipment_type_id = (int) $_POST['equipment_type_id'];
    $operation_id = (int) $_POST['operation_id'];
    $provider_id = (int) $_POST['provider_id'];
    $status_id = (int) $_POST['status_id'];
    $battery_quantity = !empty($_POST['battery_quantity']) ? (int) $_POST['battery_quantity'] : 0;
    $contracted_hours = !empty($_POST['contracted_hours']) ? (int) $_POST['contracted_hours'] : 0;
    $monthly_cost = !empty($_POST['monthly_cost']) ? (float) $_POST['monthly_cost'] : 0;
    $maintenance_interval_hours = !empty($_POST['maintenance_interval_hours']) ? (int) $_POST['maintenance_interval_hours'] : 250;
    $observations = trim($_POST['observations']);

    if (
        $id <= 0 ||
        empty($internal_number) ||
        empty($model) ||
        $equipment_type_id <= 0 ||
        $operation_id <= 0 ||
        $provider_id <= 0 ||
        $status_id <= 0
    ) {
        throw new Exception('Datos inválidos.');
    }

    $stmt_operation = $conexion->prepare("
        SELECT
            business_id,
            site_id
        FROM operations
        WHERE id = :operation_id
    ");

    $stmt_operation->execute([
        ':operation_id' => $operation_id
    ]);

    $operation_data = $stmt_operation->fetch();

    if (!$operation_data) {
        throw new Exception('Operación inválida.');
    }

    $business_id = $operation_data['business_id'];
    $site_id = $operation_data['site_id'];

    $stmt_current = $conexion->prepare("
        SELECT image
        FROM equipments
        WHERE id = :id
    ");

    $stmt_current->execute([
        ':id' => $id
    ]);

    $current_equipment = $stmt_current->fetch();

    if (!$current_equipment) {
        throw new Exception('Equipo inexistente.');
    }

    $image_name = $current_equipment['image'];

    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] === 0
    ) {

        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $extension = strtolower(
            pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            )
        );

        if (!in_array($extension, $allowed_extensions)) {
            throw new Exception('Formato de imagen no permitido.');
        }

        $upload_dir = '../../assets/uploads/equipments/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $image_name = uniqid('equipment_') . '.' . $extension;

        if (
            !move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $upload_dir . $image_name
            )
        ) {
            throw new Exception('No se pudo subir la imagen.');
        }
    }

    $sql = "
        UPDATE equipments
        SET
            internal_number = :internal_number,
            serial_number = :serial_number,
            brand = :brand,
            model = :model,
            year = :year,
            battery_quantity = :battery_quantity,
            equipment_type_id = :equipment_type_id,
            provider_id = :provider_id,
            business_id = :business_id,
            operation_id = :operation_id,
            site_id = :site_id,
            contracted_hours = :contracted_hours,
            monthly_cost = :monthly_cost,
            status_id = :status_id,
            observations = :observations,
            image = :image,
            maintenance_interval_hours = :maintenance_interval_hours
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $result = $stmt->execute([
        ':internal_number' => $internal_number,
        ':serial_number' => $serial_number,
        ':brand' => $brand,
        ':model' => $model,
        ':year' => $year,
        ':battery_quantity' => $battery_quantity,
        ':equipment_type_id' => $equipment_type_id,
        ':provider_id' => $provider_id,
        ':business_id' => $business_id,
        ':operation_id' => $operation_id,
        ':site_id' => $site_id,
        ':contracted_hours' => $contracted_hours,
        ':monthly_cost' => $monthly_cost,
        ':status_id' => $status_id,
        ':observations' => $observations,
        ':image' => $image_name,
        ':maintenance_interval_hours' => $maintenance_interval_hours,
        ':id' => $id
    ]);

    if (!$result) {
        throw new Exception('No se pudo actualizar el equipo.');
    }

    header(
        'Location: ../../views/equipments/equipment_detail.php?id=' . $id
    );

    exit;

} catch (Exception $e) {

    error_log(
        'Error update_equipment: ' . $e->getMessage()
    );

    die(
        'Ocurrió un error al actualizar el equipo.'
    );
}