<?php

require_once '../../middleware/auth.php';
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

    $selected_provider_id =
        isset($_GET['provider_id'])
            ? (int) $_GET['provider_id']
            : 0;

    $sql = "

        SELECT
            e.internal_number,
            et.type AS equipment_type,
            e.brand,
            e.model,
            p.name AS provider_name,
            o.name AS operation_name,

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

            WHERE deleted_at IS NULL
            AND cost_date >= :start_date
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

            WHERE ri.deleted_at IS NULL
AND ri.invoice_date >= :start_date
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

            WHERE deleted_at IS NULL
            AND start_date >= :start_date
            AND start_date < :end_date

            GROUP BY equipment_id
        ) downtimes
            ON downtimes.equipment_id = emr.equipment_id

        WHERE emr.active = 1
        AND emr.period_year = :period_year
        AND emr.period_month = :period_month

    ";

    $params = [
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':period_year' => $period_year,
        ':period_month' => $period_month
    ];

    if ($selected_operation_id > 0) {

        $sql .= "
            AND emr.operation_id = :operation_id
        ";

        $params[':operation_id'] =
            $selected_operation_id;
    }

    if ($selected_provider_id > 0) {

        $sql .= "
            AND emr.provider_id = :provider_id
        ";

        $params[':provider_id'] =
            $selected_provider_id;
    }

    $sql .= "
        ORDER BY
            p.name ASC,
            o.name ASC,
            e.internal_number ASC
    ";

    $stmt =
        $conexion->prepare($sql);

    $stmt->execute($params);

    $rows =
        $stmt->fetchAll();

    $filename =
        'control_facturacion_' .
        $period .
        '.csv';

    header(
        'Content-Type: text/csv; charset=utf-8'
    );

    header(
        'Content-Disposition: attachment; filename="' .
        $filename .
        '"'
    );

    $output =
        fopen(
            'php://output',
            'w'
        );

    fprintf(
        $output,
        chr(0xEF) . chr(0xBB) . chr(0xBF)
    );

    fputcsv(
        $output,
        [
            'Interno',
            'Tipo de equipo',
            'Equipo',
            'Proveedor',
            'Operacion',
            'Alquiler',
            'Horas extra',
            'Reparaciones',
            'Otros',
            'Recuperos',
            'Indisponibilidades',
            'Total'
        ],
        ';'
    );

    foreach ($rows as $row) {

        $rental =
            (float) $row['rental_cost'];

        $hours_extra =
            (float) $row['hours_extra'];

        $repairs =
            (float) $row['repair_costs'];

        $other =
            (float) $row['other_costs'];

        $recoveries =
            (float) $row['recoveries'];

        $downtime =
            (float) $row['downtime_discount'];

        $total =
            $rental
            + $hours_extra
            + $repairs
            + $other
            - $recoveries
            - $downtime;

        fputcsv(
            $output,
            [
                $row['internal_number'],
                $row['equipment_type'],
                trim(
                    ($row['brand'] ?? '') .
                    ' ' .
                    ($row['model'] ?? '')
                ),
                $row['provider_name'],
                $row['operation_name'],
                $rental,
                $hours_extra,
                $repairs,
                $other,
                $recoveries,
                $downtime,
                $total
            ],
            ';'
        );
    }

    fclose($output);

    exit;

} catch (Exception $e) {

    error_log(
        'Error export_billing_csv: ' .
        $e->getMessage()
    );

    die(
        'Ocurrió un error al exportar el reporte.'
    );
}