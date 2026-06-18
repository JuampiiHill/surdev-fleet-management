<?php

require_once '../../config/database.php';

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

    ORDER BY e.id DESC
";

$stmt_eq = $conexion->prepare($sql_eq);
$stmt_eq->execute();

$equipments = $stmt_eq->fetchAll();


/* GET STATUSES */

$sql_status = "
    SELECT *
    FROM equipment_statuses
";

$stmt_status = $conexion->prepare($sql_status);
$stmt_status->execute();

$statuses = $stmt_status->fetchAll();


/* GET EQUIPMENT TYPES */

$sql_eqt = "
    SELECT *
    FROM equipments_types
    ORDER BY type ASC
";

$stmt_eqt = $conexion->prepare($sql_eqt);
$stmt_eqt->execute();

$equipments_types = $stmt_eqt->fetchAll();


/* GET SITES */

$sql_sites = "
    SELECT *
    FROM sites
    ORDER BY name ASC
";

$stmt_sites = $conexion->prepare($sql_sites);
$stmt_sites->execute();

$sites = $stmt_sites->fetchAll();


/* GET BUSINESS */

$sql_business = "
    SELECT *
    FROM businesses
    ORDER BY name ASC
";

$stmt_business = $conexion->prepare($sql_business);
$stmt_business->execute();

$business = $stmt_business->fetchAll();


/* GET PROVIDERS */

$sql_providers = "
    SELECT *
    FROM providers
    ORDER BY name ASC
";

$stmt_provider = $conexion->prepare($sql_providers);
$stmt_provider->execute();

$providers = $stmt_provider->fetchAll();


/* GET OPERATIONS */

$sql_op = "
    SELECT *
    FROM operations
    ORDER BY name ASC
";

$stmt_op = $conexion->prepare($sql_op);
$stmt_op->execute();

$operations = $stmt_op->fetchAll();

?>