<?php

session_start();

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){

    header('Location: ../../views/dashboard/dashboard.php');
    exit;
}

$equipment_id = $_POST['equipment_id'];

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$manual_discount =
    !empty($_POST['manual_discount'])
    ? $_POST['manual_discount']
    : null;

$reason =
    $_POST['reason'] ?? null;


/* Obtener valor mensual del equipo */

$sql = "

    SELECT monthly_cost
    FROM equipments
    WHERE id = :id

";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $equipment_id
]);

$equipment = $stmt->fetch();

if(!$equipment){

    die('Equipo no encontrado');
}

/* Calculo de dias */

$days =

    floor(

        (
            strtotime($end_date)
            -
            strtotime($start_date)
        )

        / 86400

    ) + 1;

/* Calculo automatico bonificacion */

$days_in_month = date(
    't',
    strtotime($start_date)
);

$daily_rate =
    $equipment['monthly_cost']
    /
    $days_in_month;

$calculated_discount =
    $daily_rate * $days;

/* Guardar */

if(
    strtotime($_POST['end_date'])
    <
    strtotime($_POST['start_date'])
){
    die(
        'La fecha fin no puede ser menor a la fecha inicio'
    );
}

$sql_insert = "

INSERT INTO equipment_downtimes(

    equipment_id,
    start_date,
    end_date,
    days,
    monthly_rate,
    calculated_discount,
    manual_discount,
    reason,
    created_by

)

VALUES(

    :equipment_id,
    :start_date,
    :end_date,
    :days,
    :monthly_rate,
    :calculated_discount,
    :manual_discount,
    :reason,
    :created_by

)

";

$stmt_insert =
    $conexion->prepare($sql_insert);

$stmt_insert->execute([

    ':equipment_id' => $equipment_id,
    ':start_date' => $start_date,
    ':end_date' => $end_date,
    ':days' => $days,
    ':monthly_rate' => $equipment['monthly_cost'],
    ':calculated_discount' => $calculated_discount,
    ':manual_discount' => $manual_discount,
    ':reason' => $reason,
    ':created_by' => $_SESSION['id'] ?? null
]);

header(

    'Location: ../../views/equipments/equipment_detail.php?id=' .
    $equipment_id

);

exit;