<?php

session_start();

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit;
}

$equipment_id = $_POST['equipment_id'];
$maintenance_date = $_POST['maintenance_date'];
$hourmeter = $_POST['hourmeter'];
$observations = trim($_POST['observations']);

/*==================================
VALIDAR HOROMETRO
==================================*/

$sql_equipment = "
    SELECT current_hourmeter
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

if($hourmeter < $equipment['current_hourmeter']){

    die(
        'El horómetro del mantenimiento no puede ser menor al horómetro actual del equipo.'
    );
}

$sql_last = "
    SELECT hourmeter
    FROM equipment_maintenances
    WHERE equipment_id = :equipment_id
    ORDER BY maintenance_date DESC, id DESC
    LIMIT 1
";

$stmt_last = $conexion->prepare($sql_last);

$stmt_last->execute([
    ':equipment_id' => $equipment_id
]);

$last_maintenance = $stmt_last->fetch();

if(
    $last_maintenance &&
    $hourmeter <= $last_maintenance['hourmeter']
){

    die(
        'El horómetro debe ser mayor al del último mantenimiento registrado.'
    );
}

$file_name = null;

/*==================================
SUBIR ARCHIVO
==================================*/

if(
    isset($_FILES['file'])
    &&
    $_FILES['file']['error'] == 0
){

    $extension = strtolower(
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

    if(in_array($extension,$allowed)){

        $file_name =
            uniqid() .
            '.' .
            $extension;

        move_uploaded_file(
            $_FILES['file']['tmp_name'],
            '../../assets/uploads/maintenances/' .
            $file_name
        );
    }
}

/*==================================
INSERT
==================================*/

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

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':equipment_id' => $equipment_id,
    ':maintenance_date' => $maintenance_date,
    ':hourmeter' => $hourmeter,
    ':file' => $file_name,
    ':observations' => $observations
]);

/*==================================
ACTUALIZAR HOROMETRO DEL EQUIPO
==================================*/

$sql_update = "
    UPDATE equipments
    SET current_hourmeter = :hourmeter
    WHERE id = :equipment_id
      AND current_hourmeter < :hourmeter
";

$stmt_update = $conexion->prepare($sql_update);

$stmt_update->execute([
    ':hourmeter' => $hourmeter,
    ':equipment_id' => $equipment_id
]);

header(
    'Location: ../../views/equipments/equipment_detail.php?id=' .
    $equipment_id
);

exit;