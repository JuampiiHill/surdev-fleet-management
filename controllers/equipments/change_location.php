<?php

session_start();

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit;
}

$equipment_id = $_POST['equipment_id'];
$new_operation_id = $_POST['operation_id'];
$observations = trim($_POST['observations']);

/*
|--------------------------------------------------------------------------
| OBTENER EQUIPO ACTUAL
|--------------------------------------------------------------------------
*/

$sql_equipment = "
    SELECT
        business_id,
        operation_id,
        site_id
    FROM equipments
    WHERE id = :equipment_id
";

$stmt_equipment = $conexion->prepare($sql_equipment);

$stmt_equipment->execute([
    ':equipment_id' => $equipment_id
]);

$equipment = $stmt_equipment->fetch();

if(!$equipment){

    die('Equipo inexistente');
}

$old_business_id = $equipment['business_id'];
$old_operation_id = $equipment['operation_id'];
$old_site_id = $equipment['site_id'];

/*
|--------------------------------------------------------------------------
| OBTENER NUEVA OPERACION
|--------------------------------------------------------------------------
*/

$sql_operation = "
    SELECT
        business_id,
        site_id
    FROM operations
    WHERE id = :operation_id
";

$stmt_operation = $conexion->prepare($sql_operation);

$stmt_operation->execute([
    ':operation_id' => $new_operation_id
]);

$operation = $stmt_operation->fetch();

if(!$operation){

    die('Operación inválida');
}

$new_business_id = $operation['business_id'];
$new_site_id = $operation['site_id'];

/*
|--------------------------------------------------------------------------
| ACTUALIZAR EQUIPO
|--------------------------------------------------------------------------
*/

$sql_update = "
    UPDATE equipments
    SET
        business_id = :business_id,
        operation_id = :operation_id,
        site_id = :site_id
    WHERE id = :equipment_id
";

$stmt_update = $conexion->prepare($sql_update);

$stmt_update->execute([
    ':business_id' => $new_business_id,
    ':operation_id' => $new_operation_id,
    ':site_id' => $new_site_id,
    ':equipment_id' => $equipment_id
]);

/*
|--------------------------------------------------------------------------
| GUARDAR HISTORIAL
|--------------------------------------------------------------------------
*/

$sql_history = "
    INSERT INTO equipment_movements
    (
        equipment_id,
        old_business_id,
        old_operation_id,
        old_site_id,
        business_id,
        operation_id,
        site_id,
        movement_date,
        observations,
        created_by
    )
    VALUES
    (
        :equipment_id,
        :old_business_id,
        :old_operation_id,
        :old_site_id,
        :business_id,
        :operation_id,
        :site_id,
        :movement_date,
        :observations,
        :created_by
    )
";

$stmt_history = $conexion->prepare($sql_history);

$stmt_history->execute([
    ':equipment_id' => $equipment_id,

    ':old_business_id' => $old_business_id,
    ':old_operation_id' => $old_operation_id,
    ':old_site_id' => $old_site_id,

    ':business_id' => $new_business_id,
    ':operation_id' => $new_operation_id,
    ':site_id' => $new_site_id,

    ':movement_date' => date('Y-m-d'),

    ':observations' => $observations,

    ':created_by' => $_SESSION['user_id'] ?? null
]);

header(
    'Location: ../../views/equipments/equipment_detail.php?id=' .
    $equipment_id
);

exit;