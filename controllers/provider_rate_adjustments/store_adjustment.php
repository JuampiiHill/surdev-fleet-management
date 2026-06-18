<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';
require_once 'ProviderRateAdjustmentController.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }

    $provider_id =
        (int) ($_POST['provider_id'] ?? 0);

    $start_period =
        $_POST['start_period'] ?? '';

    $end_period =
        $_POST['end_period'] ?? '';

    $percentage =
        (float) ($_POST['percentage'] ?? 0);

    $description =
        trim($_POST['description'] ?? '');

    if (
        $provider_id <= 0 ||
        !preg_match('/^\d{4}-\d{2}$/', $start_period) ||
        !preg_match('/^\d{4}-\d{2}$/', $end_period)
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }

    if ($percentage < 0) {

        throw new Exception(
            'El porcentaje no puede ser negativo.'
        );
    }

    [$start_year, $start_month] =
        array_map(
            'intval',
            explode('-', $start_period)
        );

    [$end_year, $end_month] =
        array_map(
            'intval',
            explode('-', $end_period)
        );

    $start_date =
        new DateTime($start_period . '-01');

    $end_date =
        new DateTime($end_period . '-01');

    if ($end_date < $start_date) {

        throw new Exception(
            'El período hasta no puede ser menor al período desde.'
        );
    }

    $equipments =
        getActiveEquipmentsByProvider(
            $conexion,
            $provider_id
        );

    if (count($equipments) === 0) {

        throw new Exception(
            'El proveedor no tiene equipos activos.'
        );
    }

    $conexion->beginTransaction();

    $adjustment_id =
        createProviderRateAdjustment(
            $conexion,
            $provider_id,
            $start_year,
            $start_month,
            $end_year,
            $end_month,
            $percentage,
            $description,
            $_SESSION['user_id'] ?? null
        );

    $months =
        getMonthsBetweenPeriods(
            $start_year,
            $start_month,
            $end_year,
            $end_month
        );

    foreach ($equipments as $equipment) {

        $last_rate =
            getLastMonthlyRateBeforePeriod(
                $conexion,
                (int) $equipment['id'],
                $start_year,
                $start_month
            );

        if ($last_rate) {

            $base_cost =
                (float) $last_rate['monthly_cost'];

            $contracted_hours =
                (int) $last_rate['contracted_hours'];

        } else {

            $base_cost =
                (float) $equipment['monthly_cost'];

            $contracted_hours =
                (int) $equipment['contracted_hours'];
        }

        $new_cost =
            round(
                $base_cost *
                (1 + ($percentage / 100)),
                2
            );

        foreach ($months as $month) {

            upsertEquipmentMonthlyRate(
                $conexion,
                (int) $equipment['id'],
                (int) $equipment['provider_id'],
                $equipment['operation_id'] !== null ? (int) $equipment['operation_id'] : null,
                $equipment['business_id'] !== null ? (int) $equipment['business_id'] : null,
                $equipment['site_id'] !== null ? (int) $equipment['site_id'] : null,
                (int) $month['year'],
                (int) $month['month'],
                $new_cost,
                $contracted_hours,
                $adjustment_id,
                $_SESSION['user_id'] ?? null
            );
        }
    }

    $conexion->commit();

    header(
        'Location: ../../views/reports/reports.php?period=' .
        $start_period
    );

    exit;

} catch (Exception $e) {

    if (
        isset($conexion) &&
        $conexion instanceof PDO &&
        $conexion->inTransaction()
    ) {

        $conexion->rollBack();
    }

    error_log(
        'Error store_adjustment: ' .
        $e->getMessage()
    );

    die(
        'Ocurrió un error al aplicar el ajuste de tarifas.'
    );
}