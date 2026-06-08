<?php

session_start();

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit;
}

$equipment_id = $_POST['equipment_id'];
$report_date = $_POST['report_date'];
$reported_by = trim($_POST['reported_by']);
$priority = $_POST['priority'];
$failure_description = trim($_POST['failure_description']);

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
            '../../assets/uploads/repair_orders/' .
            $file_name
        );
    }
}

/*==================================
GENERAR NUMERO OR
==================================*/

$sql_last = "
    SELECT id
    FROM repair_orders
    ORDER BY id DESC
    LIMIT 1
";

$stmt_last = $conexion->prepare($sql_last);
$stmt_last->execute();

$last = $stmt_last->fetch();

$next_id = $last
    ? $last['id'] + 1
    : 1;

$order_number =
    'OR-' .
    str_pad(
        $next_id,
        5,
        '0',
        STR_PAD_LEFT
    );

/*==================================
INSERT
==================================*/

$sql = "
    INSERT INTO repair_orders
    (
        order_number,
        equipment_id,
        report_date,
        reported_by,
        priority,
        failure_description,
        file,
        created_by
    )
    VALUES
    (
        :order_number,
        :equipment_id,
        :report_date,
        :reported_by,
        :priority,
        :failure_description,
        :file,
        :created_by
    )
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':order_number' => $order_number,
    ':equipment_id' => $equipment_id,
    ':report_date' => $report_date,
    ':reported_by' => $reported_by,
    ':priority' => $priority,
    ':failure_description' => $failure_description,
    ':file' => $file_name,
    ':created_by' => $_SESSION['user_id'] ?? null
]);

header(
    'Location: ../../views/equipments/equipment_detail.php?id=' .
    $equipment_id
);

exit;