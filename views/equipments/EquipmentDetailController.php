<?php

require_once '../../config/database.php';

if (!isset($_GET['id'])) {

    header('Location: ../dashboard/dashboard.php');
    exit;
}

$equipment_id = (int) $_GET['id'];

$sql = "
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

    WHERE e.id = :id
";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $equipment_id);
$stmt->execute();

$equipment = $stmt->fetch();

if (!$equipment) {
    header('Location: ../dashboard/dashboard.php');
    exit;
}

/* OPERACIONES*/

$sql_operations = "
    SELECT
        o.id,
        o.name,
        s.name AS site_name
    FROM operations o
    LEFT JOIN sites s
        ON o.site_id = s.id
    WHERE o.active = 1
    ORDER BY o.name
";

$stmt_operations = $conexion->prepare($sql_operations);
$stmt_operations->execute();

$operations = $stmt_operations->fetchAll();

/* ULTIMO MANTENIMIENTO */

$sql_last_maintenance = "
    SELECT *
    FROM equipment_maintenances
    WHERE equipment_id = :equipment_id
    ORDER BY maintenance_date DESC, id DESC
    LIMIT 1
";

$stmt_last_maintenance = $conexion->prepare($sql_last_maintenance);

$stmt_last_maintenance->execute([
    ':equipment_id' => $equipment_id
]);

$last_maintenance = $stmt_last_maintenance->fetch();

/* CALCULO MANTENIMIENTO */

$intervalo = $equipment['maintenance_interval_hours'];

$horometro_actual = $equipment['current_hourmeter'];

if ($last_maintenance) {

    $ultimo_mantenimiento_hs =
        $last_maintenance['hourmeter'];
} else {

    $ultimo_mantenimiento_hs =
        $equipment['initial_hourmeter'];
}

$proximo_mantenimiento =
    $ultimo_mantenimiento_hs +
    $intervalo;

$horas_consumidas =
    $horometro_actual -
    $ultimo_mantenimiento_hs;

$horas_restantes =
    $proximo_mantenimiento -
    $horometro_actual;

$porcentaje = 0;

if ($intervalo > 0) {

    $porcentaje =
        ($horas_consumidas * 100)
        / $intervalo;
}

if ($porcentaje > 100) {

    $porcentaje = 100;
}

$color_grafico = '#2563eb';
$estado_mantenimiento = 'VIGENTE';

if ($horas_restantes <= 0) {

    $color_grafico = '#dc2626';
    $estado_mantenimiento = 'VENCIDO';
} elseif ($horas_restantes <= 50) {

    $color_grafico = '#f59e0b';
    $estado_mantenimiento = 'PRÓXIMO A VENCER';
}

/* GRAFICO USO MENSUAL */

$sql_chart = "
    SELECT
        MONTH(work_date) AS month_number,
        SUM(hours) AS total_hours
    FROM equipment_hour_logs
    WHERE equipment_id = :equipment_id
    GROUP BY MONTH(work_date)
    ORDER BY MONTH(work_date)
";

$stmt_chart = $conexion->prepare($sql_chart);

$stmt_chart->execute([
    ':equipment_id' => $equipment_id
]);

$chart_data = $stmt_chart->fetchAll();

$months = [
    'Ene',
    'Feb',
    'Mar',
    'Abr',
    'May',
    'Jun',
    'Jul',
    'Ago',
    'Sep',
    'Oct',
    'Nov',
    'Dic'
];

$chart_hours = array_fill(0, 12, 0);

foreach ($chart_data as $row) {

    $month_index =
        (int)$row['month_number'] - 1;

    $chart_hours[$month_index] =
        (float)$row['total_hours'];
}

/* ORDENES DE REPARACION */

$sql_repair_orders = "
    SELECT *
    FROM repair_orders
    WHERE equipment_id = :equipment_id
    ORDER BY report_date DESC
";

$stmt_repair_orders =
    $conexion->prepare($sql_repair_orders);

$stmt_repair_orders->execute([
    ':equipment_id' => $equipment_id
]);

$repair_orders =
    $stmt_repair_orders->fetchAll();

$sql_work_orders = "

    SELECT
        rwo.*,
        ro.order_number

    FROM repair_work_orders rwo

    INNER JOIN repair_orders ro
        ON rwo.repair_order_id = ro.id

    WHERE ro.equipment_id = :equipment_id

    ORDER BY rwo.work_date DESC

";

$stmt_work_orders =
    $conexion->prepare($sql_work_orders);

$stmt_work_orders->execute([
    ':equipment_id' => $equipment_id
]);

$work_orders =
    $stmt_work_orders->fetchAll();

$sql_preventives = "

    SELECT *
    FROM equipment_maintenances
    WHERE equipment_id = :equipment_id
    ORDER BY maintenance_date DESC

";

$stmt_preventives =
    $conexion->prepare($sql_preventives);

$stmt_preventives->execute([
    ':equipment_id' => $equipment_id
]);

$preventives =
    $stmt_preventives->fetchAll();

$sql_downtimes = "

    SELECT *
    FROM equipment_downtimes
    WHERE equipment_id = :equipment_id
    ORDER BY start_date DESC

";

$stmt_downtimes =
    $conexion->prepare($sql_downtimes);

$stmt_downtimes->execute([

    ':equipment_id' => $equipment_id

]);

$downtimes =
    $stmt_downtimes->fetchAll();

$sql_month_costs = "

SELECT
    cost_type,
    COALESCE(SUM(amount),0) total

FROM equipment_costs

WHERE equipment_id = :equipment_id
AND MONTH(cost_date) = MONTH(CURDATE())
AND YEAR(cost_date) = YEAR(CURDATE())

GROUP BY cost_type

";

$stmt_month_costs = $conexion->prepare($sql_month_costs);

$stmt_month_costs->execute([
    ':equipment_id' => $equipment_id
]);

$month_costs = $stmt_month_costs->fetchAll(PDO::FETCH_KEY_PAIR);

$sql_month_downtime = "

SELECT
    COALESCE(
        SUM(
            IFNULL(
                manual_discount,
                calculated_discount
            )
        ),
    0) total

FROM equipment_downtimes

WHERE equipment_id = :equipment_id
AND MONTH(start_date) = MONTH(CURDATE())
AND YEAR(start_date) = YEAR(CURDATE())

";

$stmt_month_downtime =
    $conexion->prepare($sql_month_downtime);

$stmt_month_downtime->execute([
    ':equipment_id' => $equipment_id
]);

$downtime_discount =
    $stmt_month_downtime->fetchColumn();

$monthly_cost =
    $equipment['monthly_cost'];

$sql_repair_costs = "

SELECT
    COALESCE(SUM(ri.amount),0) total

FROM repair_invoices ri

INNER JOIN repair_orders ro
    ON ri.repair_order_id = ro.id

WHERE ro.equipment_id = :equipment_id
AND MONTH(ri.invoice_date) = MONTH(CURDATE())
AND YEAR(ri.invoice_date) = YEAR(CURDATE())

";

$stmt_repair_costs =
    $conexion->prepare($sql_repair_costs);

$stmt_repair_costs->execute([
    ':equipment_id' => $equipment_id
]);

$repair_cost =
    (float) $stmt_repair_costs->fetchColumn();

$extra_costs =
    ($month_costs['HORAS_EXTRAS'] ?? 0)
    +
    ($month_costs['TRASLADO'] ?? 0)
    +
    ($month_costs['OTROS'] ?? 0);

$recoveries =
    $month_costs['RECUPERO'] ?? 0;

$total_month_cost =

    $monthly_cost
    + $repair_cost
    + $extra_costs
    - $recoveries
    - $downtime_discount;

$sql_costs = "

SELECT *
FROM equipment_costs

WHERE equipment_id = :equipment_id

ORDER BY cost_date DESC

";

$stmt_costs = $conexion->prepare($sql_costs);

$stmt_costs->execute([
    ':equipment_id' => $equipment_id
]);

$costs = $stmt_costs->fetchAll();

?>