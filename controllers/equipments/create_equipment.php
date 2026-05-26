<?php

session_start();

require_once '../../config/database.php';

/* =========================================================
   VALIDAR MÉTODO
========================================================= */

if($_SERVER['REQUEST_METHOD'] != 'POST'){

    header('Location: ../../views/dashboard/dashboard.php');
    exit;
}

/* =========================================================
   DATOS DEL FORMULARIO
========================================================= */

$internal_number   = trim($_POST['internal_number']);
$brand             = trim($_POST['brand']);
$model             = trim($_POST['model']);

$year              = !empty($_POST['year'])
                    ? $_POST['year']
                    : null;

$serial_number     = trim($_POST['serial_number']);

$contracted_hours  = !empty($_POST['contracted_hours'])
                    ? $_POST['contracted_hours']
                    : 0;

$equipment_type_id = $_POST['equipment_type_id'];

$provider_id       = $_POST['provider_id'];

$operation_id      = $_POST['operation_id'];

$status_id         = $_POST['status_id'];

$monthly_cost      = !empty($_POST['monthly_cost'])
                    ? $_POST['monthly_cost']
                    : 0;

$battery_quantity  = !empty($_POST['battery_quantity'])
                    ? $_POST['battery_quantity']
                    : 0;

$observations      = trim($_POST['observations']);

/* =========================================================
   OBTENER BUSINESS Y SITE DESDE OPERACIÓN
========================================================= */

$sql_operation = "
    SELECT
        business_id,
        site_id
    FROM operations
    WHERE id = ?
";

$stmt_operation = $conexion->prepare($sql_operation);

$stmt_operation->execute([
    $operation_id
]);

$operation_data = $stmt_operation->fetch();

if(!$operation_data){

    die('Operación inválida');
}

$business_id = $operation_data['business_id'];

$site_id = $operation_data['site_id'];

/* =========================================================
   SUBIDA DE IMAGEN
========================================================= */

$image_name = null;

if(
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
){

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

    if(in_array($extension, $allowed_extensions)){

        $image_name = uniqid() . '.' . $extension;

        $destination =
            '../../assets/uploads/equipments/' .
            $image_name;

        move_uploaded_file(
            $tmp_name,
            $destination
        );
    }
}

/* =========================================================
   INSERT EQUIPO
========================================================= */

$sql = "
INSERT INTO equipments (

    internal_number,
    brand,
    model,
    year,
    serial_number,
    battery_quantity,
    contracted_hours,
    monthly_cost,

    equipment_type_id,
    provider_id,
    operation_id,
    business_id,
    site_id,
    status_id,

    observations,
    image,
    active

) VALUES (

    :internal_number,
    :brand,
    :model,
    :year,
    :serial_number,
    :battery_quantity,
    :contracted_hours,
    :monthly_cost,

    :equipment_type_id,
    :provider_id,
    :operation_id,
    :business_id,
    :site_id,
    :status_id,

    :observations,
    :image,
    1
)
";

$stmt = $conexion->prepare($sql);

/* =========================================================
   BINDS
========================================================= */

$stmt->bindParam(
    ':internal_number',
    $internal_number
);

$stmt->bindParam(
    ':brand',
    $brand
);

$stmt->bindParam(
    ':model',
    $model
);

$stmt->bindParam(
    ':year',
    $year
);

$stmt->bindParam(
    ':serial_number',
    $serial_number
);

$stmt->bindParam(
    ':battery_quantity',
    $battery_quantity
);

$stmt->bindParam(
    ':contracted_hours',
    $contracted_hours
);

$stmt->bindParam(
    ':monthly_cost',
    $monthly_cost
);

$stmt->bindParam(
    ':equipment_type_id',
    $equipment_type_id
);

$stmt->bindParam(
    ':provider_id',
    $provider_id
);

$stmt->bindParam(
    ':operation_id',
    $operation_id
);

$stmt->bindParam(
    ':business_id',
    $business_id
);

$stmt->bindParam(
    ':site_id',
    $site_id
);

$stmt->bindParam(
    ':status_id',
    $status_id
);

$stmt->bindParam(
    ':observations',
    $observations
);

$stmt->bindParam(
    ':image',
    $image_name
);

/* =========================================================
   EJECUTAR
========================================================= */

$stmt->execute();

/* =========================================================
   REDIRECT
========================================================= */

header(
    'Location: ../../views/dashboard/dashboard.php'
);

exit;