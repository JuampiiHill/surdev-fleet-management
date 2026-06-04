<?php

session_start();

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header('Location: ../../views/dashboard/dashboard.php');
    exit;
}

/* =====================
   CAPTURAS DEL FORM
========================= */

$internal_number = trim($_POST['internal_number']);
$brand = trim($_POST['brand']);
$model = trim($_POST['model']);
$year = !empty($_POST['year']) ? (int)$_POST['year'] : null;
$serial_number = trim($_POST['serial_number']);
$equipment_type_id = (int)$_POST['equipment_type_id'];
$operation_id = (int)$_POST['operation_id'];
$provider_id = (int)$_POST['provider_id'];
$initial_hourmeter = !empty($_POST['initial_hourmeter']) ? (float)$_POST['initial_hourmeter'] : 0;
$maintenance_interval_hours = !empty($_POST['maintenance_interval_hours']) ? (int)$_POST['maintenance_interval_hours'] : 250;
$contracted_hours = !empty($_POST['contracted_hours']) ? (int)$_POST['contracted_hours'] : 0;
$monthly_cost = !empty($_POST['monthly_cost']) ? (float)$_POST['monthly_cost'] : 0;
$battery_quantity = !empty($_POST['battery_quantity']) ? (int)$_POST['battery_quantity'] : 0;
$status_id = (int)$_POST['status_id'];
$observations = trim($_POST['observations']);

/* ==========================================
   OBTENER NEGOCIO Y SITES DESDE OPERACIÓN
=========================================== */

$sql_operation = "
    SELECT
        business_id,
        site_id
    FROM operations
    WHERE id = ?
";

$stmt_operation = $conexion->prepare($sql_operation);

$stmt_operation->execute([$operation_id]);
$operation_data = $stmt_operation->fetch();

if (!$operation_data) {
    die('Operación inválida');
}

$business_id = $operation_data['business_id'];
$site_id = $operation_data['site_id'];
$image_name = null;

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
) {

    $allowed_extensions = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    $file_name = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];

    $extension = strtolower(
        pathinfo(
            $file_name,
            PATHINFO_EXTENSION
        )
    );

    if (in_array($extension, $allowed_extensions)) {

        $image_name = uniqid() . '.' . $extension;

        $destination = '../../assets/uploads/equipments/' . $image_name;

        move_uploaded_file(
            $tmp_name, $destination);
    }
}

/* ============
   INSERT 
============ */

$sql = "
INSERT INTO equipments (

    internal_number,
    serial_number,
    brand,
    model,
    year,
    battery_quantity,
    equipment_type_id,
    provider_id,
    business_id,
    operation_id,
    site_id,
    contracted_hours,
    monthly_cost,
    status_id,
    active,
    observations,
    image,
    initial_hourmeter,
    current_hourmeter,
    maintenance_interval_hours

)
VALUES (

    :internal_number,
    :serial_number,
    :brand,
    :model,
    :year,
    :battery_quantity,
    :equipment_type_id,
    :provider_id,
    :business_id,
    :operation_id,
    :site_id,
    :contracted_hours,
    :monthly_cost,
    :status_id,
    1,
    :observations,
    :image,
    :initial_hourmeter,
    :initial_hourmeter,
    :maintenance_interval_hours

)
";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(':internal_number', $internal_number);
$stmt->bindParam(':serial_number', $serial_number);
$stmt->bindParam(':brand', $brand);
$stmt->bindParam(':model', $model);
$stmt->bindParam(':year', $year);
$stmt->bindParam(':battery_quantity', $battery_quantity);
$stmt->bindParam(':equipment_type_id', $equipment_type_id);
$stmt->bindParam(':provider_id', $provider_id);
$stmt->bindParam(':business_id', $business_id);
$stmt->bindParam(':operation_id', $operation_id);
$stmt->bindParam(':site_id', $site_id);
$stmt->bindParam(':contracted_hours', $contracted_hours);
$stmt->bindParam(':monthly_cost', $monthly_cost);
$stmt->bindParam(':status_id', $status_id);
$stmt->bindParam(':observations', $observations);
$stmt->bindParam(':image', $image_name);
$stmt->bindParam(':initial_hourmeter', $initial_hourmeter);
$stmt->bindParam(':maintenance_interval_hours', $maintenance_interval_hours);

$stmt->execute();

header(
    'Location: ../../views/dashboard/dashboard.php'
);

exit;