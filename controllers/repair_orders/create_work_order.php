<?php

session_start();

require_once '../../config/database.php';

$repair_order_id = $_POST['repair_order_id'];

$file_name = null;

if(
    isset($_FILES['file']) &&
    $_FILES['file']['error'] == 0
){

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
    ':mechanic_name' => $_POST['mechanic_name'],
    ':work_date' => $_POST['work_date'],
    ':work_description' => $_POST['work_description'],
    ':work_order_number' => $_POST['work_order_number'],
    ':file' => $file_name,
    ':created_by' => $_SESSION['user_id'] ?? null

]);

$conexion->prepare("
    UPDATE repair_orders
    SET status='EN CURSO'
    WHERE id=?
")->execute([$repair_order_id]);

header(
    'Location: ../../modules/repair_orders/repair-order-detail.php?id=' .
    $repair_order_id
);

exit;