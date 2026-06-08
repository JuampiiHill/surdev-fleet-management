<?php

session_start();

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header('Location: ../../dashboard.php');
    exit;
}

$repair_order_id = $_POST['repair_order_id'];

$quote_id = !empty($_POST['quote_id'])
    ? $_POST['quote_id']
    : null;

$invoice_number = $_POST['invoice_number'];

$invoice_date = $_POST['invoice_date'];

$amount = $_POST['amount'];

$file = null;

$upload_dir =
    '../../assets/uploads/repair_invoices/';

if(!is_dir($upload_dir)){

    mkdir($upload_dir, 0777, true);
}

if(!empty($_FILES['file']['name'])){

    $file =
        time().'_'.
        basename($_FILES['file']['name']);

    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $upload_dir.$file
    );
}

$sql = "

INSERT INTO repair_invoices(

    repair_order_id,
    quote_id,
    invoice_number,
    invoice_date,
    amount,
    file,
    created_by

) VALUES (

    :repair_order_id,
    :quote_id,
    :invoice_number,
    :invoice_date,
    :amount,
    :file,
    :created_by

)

";

$stmt = $conexion->prepare($sql);

$stmt->execute([

    ':repair_order_id' => $repair_order_id,
    ':quote_id' => $quote_id,
    ':invoice_number' => $invoice_number,
    ':invoice_date' => $invoice_date,
    ':amount' => $amount,
    ':file' => $file,
    ':created_by' => $_SESSION['user_id'] ?? null

]);

header(
    'Location: ../../modules/repair_orders/repair-order-detail.php?id='
    .$repair_order_id
);

exit;