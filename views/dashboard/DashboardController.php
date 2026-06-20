<?php

require_once '../../config/database.php';

/* FILTROS */

$selected_operation_id =
    isset($_GET['operation_id'])
        ? (int) $_GET['operation_id']
        : 0;

$selected_business_id =
    isset($_GET['business_id'])
        ? (int) $_GET['business_id']
        : 0;

$selected_site_id =
    isset($_GET['site_id'])
        ? (int) $_GET['site_id']
        : 0;

$selected_provider_id =
    isset($_GET['provider_id'])
        ? (int) $_GET['provider_id']
        : 0;

$selected_status_id =
    isset($_GET['status_id'])
        ? (int) $_GET['status_id']
        : 0;

$search =
    trim($_GET['search'] ?? '');

$selected_equipment_type_id =
    isset($_GET['equipment_type_id'])
        ? (int) $_GET['equipment_type_id']
        : 0;


/* GET EQUIPMENTS */

$sql_eq = "
    SELECT
        e.*,
        o.name AS operation_name,
        s.name AS site_name,
        b.name AS business_name,
        p.name AS provider_name,
        et.type AS equipment_type,
        es.name AS status_name

    FROM equipments e

    LEFT JOIN operations o
        ON e.operation_id = o.id

    LEFT JOIN sites s
        ON e.site_id = s.id

    LEFT JOIN businesses b
        ON e.business_id = b.id

    LEFT JOIN providers p
        ON e.provider_id = p.id

    LEFT JOIN equipments_types et
        ON e.equipment_type_id = et.id

    LEFT JOIN equipment_statuses es
        ON e.status_id = es.id

    WHERE e.active = 1
";

$params = [];

if ($selected_operation_id > 0) {

    $sql_eq .= "
        AND e.operation_id = :operation_id
    ";

    $params[':operation_id'] =
        $selected_operation_id;
}

if ($selected_business_id > 0) {

    $sql_eq .= "
        AND e.business_id = :business_id
    ";

    $params[':business_id'] =
        $selected_business_id;
}

if ($selected_site_id > 0) {

    $sql_eq .= "
        AND e.site_id = :site_id
    ";

    $params[':site_id'] =
        $selected_site_id;
}

if ($selected_provider_id > 0) {

    $sql_eq .= "
        AND e.provider_id = :provider_id
    ";

    $params[':provider_id'] =
        $selected_provider_id;
}

if ($selected_status_id > 0) {

    $sql_eq .= "
        AND e.status_id = :status_id
    ";

    $params[':status_id'] =
        $selected_status_id;
}

if ($selected_equipment_type_id > 0) {

    $sql_eq .= "
        AND e.equipment_type_id = :equipment_type_id
    ";

    $params[':equipment_type_id'] =
        $selected_equipment_type_id;
}

if (!empty($search)) {

    $sql_eq .= "
        AND (
            e.internal_number LIKE :search
            OR e.brand LIKE :search
            OR e.model LIKE :search
            OR e.serial_number LIKE :search
        )
    ";

    $params[':search'] =
        '%' . $search . '%';
}

$sql_eq .= "
    ORDER BY e.id DESC
";

$stmt_eq = $conexion->prepare($sql_eq);

$stmt_eq->execute($params);

$equipments = $stmt_eq->fetchAll();


/* GET STATUSES */

$sql_status = "
    SELECT DISTINCT
        es.id,
        es.name
    FROM equipment_statuses es
    INNER JOIN equipments e
        ON e.status_id = es.id
    WHERE e.active = 1
    ORDER BY es.name ASC
";

$stmt_status = $conexion->prepare($sql_status);
$stmt_status->execute();

$statuses = $stmt_status->fetchAll();


/* GET EQUIPMENT TYPES */

$sql_eqt = "
    SELECT DISTINCT
        et.id,
        et.type
    FROM equipments_types et
    INNER JOIN equipments e
        ON e.equipment_type_id = et.id
    WHERE e.active = 1
    ORDER BY et.type ASC
";

$stmt_eqt = $conexion->prepare($sql_eqt);
$stmt_eqt->execute();

$equipments_types = $stmt_eqt->fetchAll();


/* GET SITES */

$sql_sites = "
    SELECT DISTINCT
        s.id,
        s.name
    FROM sites s
    INNER JOIN equipments e
        ON e.site_id = s.id
    WHERE e.active = 1
    ORDER BY s.name ASC
";

$stmt_sites = $conexion->prepare($sql_sites);
$stmt_sites->execute();

$sites = $stmt_sites->fetchAll();


/* GET BUSINESS */

$sql_business = "
    SELECT DISTINCT
        b.id,
        b.name
    FROM businesses b
    INNER JOIN equipments e
        ON e.business_id = b.id
    WHERE e.active = 1
    ORDER BY b.name ASC
";

$stmt_business = $conexion->prepare($sql_business);
$stmt_business->execute();

$business = $stmt_business->fetchAll();


/* GET PROVIDERS */

$sql_providers = "
    SELECT DISTINCT
        p.id,
        p.name
    FROM providers p
    INNER JOIN equipments e
        ON e.provider_id = p.id
    WHERE e.active = 1
    ORDER BY p.name ASC
";

$stmt_provider = $conexion->prepare($sql_providers);
$stmt_provider->execute();

$providers = $stmt_provider->fetchAll();


/* GET OPERATIONS */

$sql_op = "
    SELECT DISTINCT
        o.id,
        o.name
    FROM operations o
    INNER JOIN equipments e
        ON e.operation_id = o.id
    WHERE e.active = 1
    ORDER BY o.name ASC
";

$stmt_op = $conexion->prepare($sql_op);
$stmt_op->execute();

$operations = $stmt_op->fetchAll();

?>