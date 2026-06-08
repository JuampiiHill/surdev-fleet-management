<?php

session_start();

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../dashboard.php');
    exit;
}

$repair_order_id = $_POST['repair_order_id'];
$quote_number    = $_POST['quote_number'];
$quote_date      = $_POST['quote_date'];
$amount          = $_POST['amount'] ?: null;

$file_1 = null;
$file_2 = null;

$upload_dir =
    '../../assets/uploads/repair_quotes/';

if(!is_dir($upload_dir)){
    mkdir($upload_dir, 0777, true);
}

if(!empty($_FILES['file_1']['name'])){

    $file_1 =
        time().'_1_'.
        basename($_FILES['file_1']['name']);

    move_uploaded_file(
        $_FILES['file_1']['tmp_name'],
        $upload_dir.$file_1
    );
}

if(!empty($_FILES['file_2']['name'])){

    $file_2 =
        time().'_2_'.
        basename($_FILES['file_2']['name']);

    move_uploaded_file(
        $_FILES['file_2']['tmp_name'],
        $upload_dir.$file_2
    );
}

$sql = "

INSERT INTO repair_quotes(

    repair_order_id,
    quote_number,
    quote_date,
    amount,
    file_1,
    file_2,
    created_by

) VALUES (

    :repair_order_id,
    :quote_number,
    :quote_date,
    :amount,
    :file_1,
    :file_2,
    :created_by

)

";

$stmt = $conexion->prepare($sql);

$stmt->execute([

    ':repair_order_id' => $repair_order_id,
    ':quote_number'    => $quote_number,
    ':quote_date'      => $quote_date,
    ':amount'          => $amount,
    ':file_1'          => $file_1,
    ':file_2'          => $file_2,
    ':created_by'      => $_SESSION['user_id'] ?? null

]);

header(
    'Location: ../../modules/repair_orders/repair-order-detail.php?id='
    .$repair_order_id
);

exit;