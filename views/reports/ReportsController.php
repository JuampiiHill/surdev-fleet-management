<?php

require_once '../../config/database.php';

try {

    $period =
        $_GET['period']
        ??
        date('Y-m');

    if (!preg_match('/^\d{4}-\d{2}$/', $period)) {

        $period =
            date('Y-m');
    }

    $start_date =
        $period . '-01';

    $end_date =
        date(
            'Y-m-d',
            strtotime($start_date . ' +1 month')
        );

    $period_year =
        (int) date(
            'Y',
            strtotime($start_date)
        );

    $period_month =
        (int) date(
            'm',
            strtotime($start_date)
        );

    $selected_operation_id =
    isset($_GET['operation_id'])
        ? (int) $_GET['operation_id']
        : 0;

    $selected_provider_id = isset($_GET['provider_id']) ? (int) $_GET['provider_id'] : 0;

    $sql_providers = "
    SELECT id, name
    FROM providers
    ORDER BY name ASC
";

$stmt_providers =
    $conexion->prepare($sql_providers);

$stmt_providers->execute();

$providers =
    $stmt_providers->fetchAll();


$sql_operations = "
    SELECT id, name
    FROM operations
    ORDER BY name ASC
";

$stmt_operations =
    $conexion->prepare($sql_operations);

$stmt_operations->execute();

$operations =
    $stmt_operations->fetchAll();


    /* COSTOS POR OPERACION */

    $sql_by_operation = "

        SELECT
            o.id AS operation_id,
            o.name AS operation_name,

            COALESCE(SUM(emr.monthly_cost), 0) AS rental_cost,

            COALESCE(SUM(extra_costs.hours_extra), 0) AS hours_extra,
            COALESCE(SUM(extra_costs.others), 0) AS other_costs,
            COALESCE(SUM(extra_costs.recoveries), 0) AS recoveries,

            COALESCE(SUM(repair_costs.total), 0) AS repair_costs,

            COALESCE(SUM(downtimes.total), 0) AS downtime_discount

        FROM equipment_monthly_rates emr

        INNER JOIN equipments e
            ON emr.equipment_id = e.id

        LEFT JOIN operations o
            ON emr.operation_id = o.id

        LEFT JOIN (
            SELECT
                equipment_id,

                SUM(
                    CASE
                        WHEN cost_type = 'HORAS_EXTRAS'
                        THEN amount
                        ELSE 0
                    END
                ) AS hours_extra,

                SUM(
                    CASE
                        WHEN cost_type IN ('TRASLADO', 'OTROS')
                        THEN amount
                        ELSE 0
                    END
                ) AS others,

                SUM(
                    CASE
                        WHEN cost_type = 'RECUPERO'
                        THEN amount
                        ELSE 0
                    END
                ) AS recoveries

            FROM equipment_costs

            WHERE cost_date >= :start_date
            AND cost_date < :end_date

            GROUP BY equipment_id
        ) extra_costs
            ON extra_costs.equipment_id = emr.equipment_id

        LEFT JOIN (
            SELECT
                ro.equipment_id,
                SUM(ri.amount) AS total

            FROM repair_invoices ri

            INNER JOIN repair_orders ro
                ON ri.repair_order_id = ro.id

            WHERE ri.invoice_date >= :start_date
            AND ri.invoice_date < :end_date

            GROUP BY ro.equipment_id
        ) repair_costs
            ON repair_costs.equipment_id = emr.equipment_id

        LEFT JOIN (
            SELECT
                equipment_id,
                SUM(
                    IFNULL(
                        manual_discount,
                        calculated_discount
                    )
                ) AS total

            FROM equipment_downtimes

            WHERE start_date >= :start_date
            AND start_date < :end_date

            GROUP BY equipment_id
        ) downtimes
            ON downtimes.equipment_id = emr.equipment_id

        WHERE emr.active = 1
        AND emr.period_year = :period_year
        AND emr.period_month = :period_month

        GROUP BY o.id, o.name

        ORDER BY o.name ASC

    ";

    $stmt_by_operation =
        $conexion->prepare($sql_by_operation);

    $stmt_by_operation->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':period_year' => $period_year,
        ':period_month' => $period_month
    ]);

    $billing_by_operation =
        $stmt_by_operation->fetchAll();

    /* COSTOS POR NEGOCIO */

    $sql_by_business = "

        SELECT
            b.id AS business_id,
            b.name AS business_name,

            COALESCE(SUM(emr.monthly_cost), 0) AS rental_cost,

            COALESCE(SUM(extra_costs.hours_extra), 0) AS hours_extra,
            COALESCE(SUM(extra_costs.others), 0) AS other_costs,
            COALESCE(SUM(extra_costs.recoveries), 0) AS recoveries,

            COALESCE(SUM(repair_costs.total), 0) AS repair_costs,

            COALESCE(SUM(downtimes.total), 0) AS downtime_discount

        FROM equipment_monthly_rates emr

        INNER JOIN equipments e
            ON emr.equipment_id = e.id

        LEFT JOIN businesses b
            ON emr.business_id = b.id

        LEFT JOIN (
            SELECT
                equipment_id,

                SUM(
                    CASE
                        WHEN cost_type = 'HORAS_EXTRAS'
                        THEN amount
                        ELSE 0
                    END
                ) AS hours_extra,

                SUM(
                    CASE
                        WHEN cost_type IN ('TRASLADO', 'OTROS')
                        THEN amount
                        ELSE 0
                    END
                ) AS others,

                SUM(
                    CASE
                        WHEN cost_type = 'RECUPERO'
                        THEN amount
                        ELSE 0
                    END
                ) AS recoveries

            FROM equipment_costs

            WHERE cost_date >= :start_date
            AND cost_date < :end_date

            GROUP BY equipment_id
        ) extra_costs
            ON extra_costs.equipment_id = emr.equipment_id

        LEFT JOIN (
            SELECT
                ro.equipment_id,
                SUM(ri.amount) AS total

            FROM repair_invoices ri

            INNER JOIN repair_orders ro
                ON ri.repair_order_id = ro.id

            WHERE ri.invoice_date >= :start_date
            AND ri.invoice_date < :end_date

            GROUP BY ro.equipment_id
        ) repair_costs
            ON repair_costs.equipment_id = emr.equipment_id

        LEFT JOIN (
            SELECT
                equipment_id,
                SUM(
                    IFNULL(
                        manual_discount,
                        calculated_discount
                    )
                ) AS total

            FROM equipment_downtimes

            WHERE start_date >= :start_date
            AND start_date < :end_date

            GROUP BY equipment_id
        ) downtimes
            ON downtimes.equipment_id = emr.equipment_id

        WHERE emr.active = 1
        AND emr.period_year = :period_year
        AND emr.period_month = :period_month

        GROUP BY b.id, b.name

        ORDER BY b.name ASC

    ";

    $stmt_by_business =
        $conexion->prepare($sql_by_business);

    $stmt_by_business->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':period_year' => $period_year,
        ':period_month' => $period_month
    ]);

    $billing_by_business =
        $stmt_by_business->fetchAll();

    /* RESUMEN GENERAL */

    $summary = [
        'rental_cost' => 0,
        'hours_extra' => 0,
        'repair_costs' => 0,
        'other_costs' => 0,
        'recoveries' => 0,
        'downtime_discount' => 0,
        'total' => 0
    ];

    foreach ($billing_by_operation as $row) {

        $summary['rental_cost'] +=
            (float) $row['rental_cost'];

        $summary['hours_extra'] +=
            (float) $row['hours_extra'];

        $summary['repair_costs'] +=
            (float) $row['repair_costs'];

        $summary['other_costs'] +=
            (float) $row['other_costs'];

        $summary['recoveries'] +=
            (float) $row['recoveries'];

        $summary['downtime_discount'] +=
            (float) $row['downtime_discount'];
    }

    $summary['total'] =
        $summary['rental_cost']
        + $summary['hours_extra']
        + $summary['repair_costs']
        + $summary['other_costs']
        - $summary['recoveries']
        - $summary['downtime_discount'];

    $sql_equipment_detail = "

    SELECT
        e.id AS equipment_id,
        e.internal_number,
        e.brand,
        e.model,

        et.type AS equipment_type,
        p.name AS provider_name,
        o.name AS operation_name,
        b.name AS business_name,

        COALESCE(emr.monthly_cost, 0) AS rental_cost,

        COALESCE(extra_costs.hours_extra, 0) AS hours_extra,
        COALESCE(extra_costs.others, 0) AS other_costs,
        COALESCE(extra_costs.recoveries, 0) AS recoveries,

        COALESCE(repair_costs.total, 0) AS repair_costs,

        COALESCE(downtimes.total, 0) AS downtime_discount

    FROM equipment_monthly_rates emr

    INNER JOIN equipments e
        ON emr.equipment_id = e.id

    LEFT JOIN equipments_types et
        ON e.equipment_type_id = et.id

    LEFT JOIN providers p
        ON emr.provider_id = p.id

    LEFT JOIN operations o
        ON emr.operation_id = o.id

    LEFT JOIN businesses b
        ON emr.business_id = b.id

    LEFT JOIN (
        SELECT
            equipment_id,

            SUM(
                CASE
                    WHEN cost_type = 'HORAS_EXTRAS'
                    THEN amount
                    ELSE 0
                END
            ) AS hours_extra,

            SUM(
                CASE
                    WHEN cost_type IN ('TRASLADO', 'OTROS')
                    THEN amount
                    ELSE 0
                END
            ) AS others,

            SUM(
                CASE
                    WHEN cost_type = 'RECUPERO'
                    THEN amount
                    ELSE 0
                END
            ) AS recoveries

        FROM equipment_costs

        WHERE cost_date >= :start_date
        AND cost_date < :end_date

        GROUP BY equipment_id
    ) extra_costs
        ON extra_costs.equipment_id = emr.equipment_id

    LEFT JOIN (
        SELECT
            ro.equipment_id,
            SUM(ri.amount) AS total

        FROM repair_invoices ri

        INNER JOIN repair_orders ro
            ON ri.repair_order_id = ro.id

        WHERE ri.invoice_date >= :start_date
        AND ri.invoice_date < :end_date

        GROUP BY ro.equipment_id
    ) repair_costs
        ON repair_costs.equipment_id = emr.equipment_id

    LEFT JOIN (
        SELECT
            equipment_id,
            SUM(
                IFNULL(
                    manual_discount,
                    calculated_discount
                )
            ) AS total

        FROM equipment_downtimes

        WHERE start_date >= :start_date
        AND start_date < :end_date

        GROUP BY equipment_id
    ) downtimes
        ON downtimes.equipment_id = emr.equipment_id

    WHERE emr.active = 1
    AND emr.period_year = :period_year
    AND emr.period_month = :period_month

";

$params_equipment_detail = [
    ':start_date' => $start_date,
    ':end_date' => $end_date,
    ':period_year' => $period_year,
    ':period_month' => $period_month
];

if ($selected_operation_id > 0) {

    $sql_equipment_detail .= "
        AND emr.operation_id = :operation_id
    ";

    $params_equipment_detail[':operation_id'] =
        $selected_operation_id;
}

if ($selected_provider_id > 0) {

    $sql_equipment_detail .= "
        AND emr.provider_id = :provider_id
    ";

    $params_equipment_detail[':provider_id'] =
        $selected_provider_id;
}

$sql_equipment_detail .= "
    ORDER BY
        p.name ASC,
        o.name ASC,
        e.internal_number ASC
";

$stmt_equipment_detail =
    $conexion->prepare($sql_equipment_detail);

$stmt_equipment_detail->execute(
    $params_equipment_detail
);

$billing_equipment_detail =
    $stmt_equipment_detail->fetchAll();

} catch (PDOException $e) {

    error_log(
        'Error ReportsController: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar los reportes.'
    );
}