<?php

require_once '../../config/database.php';

function createProviderRateAdjustment(
    PDO $conexion,
    int $provider_id,
    int $start_year,
    int $start_month,
    int $end_year,
    int $end_month,
    float $percentage,
    string $description,
    ?int $created_by
): int
{
    $sql = "
        INSERT INTO provider_rate_adjustments
        (
            provider_id,
            start_period_year,
            start_period_month,
            end_period_year,
            end_period_month,
            percentage,
            description,
            created_by
        )
        VALUES
        (
            :provider_id,
            :start_year,
            :start_month,
            :end_year,
            :end_month,
            :percentage,
            :description,
            :created_by
        )
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':provider_id' => $provider_id,
        ':start_year' => $start_year,
        ':start_month' => $start_month,
        ':end_year' => $end_year,
        ':end_month' => $end_month,
        ':percentage' => $percentage,
        ':description' => $description,
        ':created_by' => $created_by
    ]);

    return (int) $conexion->lastInsertId();
}

function getActiveEquipmentsByProvider(
    PDO $conexion,
    int $provider_id
): array
{
    $sql = "
        SELECT
            id,
            provider_id,
            operation_id,
            business_id,
            site_id,
            monthly_cost,
            contracted_hours
        FROM equipments
        WHERE provider_id = :provider_id
        AND active = 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':provider_id' => $provider_id
    ]);

    return $stmt->fetchAll();
}

function getLastMonthlyRateBeforePeriod(
    PDO $conexion,
    int $equipment_id,
    int $year,
    int $month
): array|false
{
    $sql = "
        SELECT *
        FROM equipment_monthly_rates
        WHERE equipment_id = :equipment_id
        AND (
            period_year < :year
            OR (
                period_year = :year
                AND period_month < :month
            )
        )
        ORDER BY period_year DESC, period_month DESC
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':equipment_id' => $equipment_id,
        ':year' => $year,
        ':month' => $month
    ]);

    return $stmt->fetch();
}

function upsertEquipmentMonthlyRate(
    PDO $conexion,
    int $equipment_id,
    ?int $provider_id,
    ?int $operation_id,
    ?int $business_id,
    ?int $site_id,
    int $year,
    int $month,
    float $monthly_cost,
    int $contracted_hours,
    int $adjustment_id,
    ?int $created_by
): bool
{
    $sql = "
        INSERT INTO equipment_monthly_rates
        (
            equipment_id,
            provider_id,
            operation_id,
            business_id,
            site_id,
            period_year,
            period_month,
            monthly_cost,
            contracted_hours,
            adjustment_id,
            source,
            active,
            created_by
        )
        VALUES
        (
            :equipment_id,
            :provider_id,
            :operation_id,
            :business_id,
            :site_id,
            :period_year,
            :period_month,
            :monthly_cost,
            :contracted_hours,
            :adjustment_id,
            'AJUSTE_PROVEEDOR',
            1,
            :created_by
        )
        ON DUPLICATE KEY UPDATE
            provider_id = VALUES(provider_id),
            operation_id = VALUES(operation_id),
            business_id = VALUES(business_id),
            site_id = VALUES(site_id),
            monthly_cost = VALUES(monthly_cost),
            contracted_hours = VALUES(contracted_hours),
            adjustment_id = VALUES(adjustment_id),
            source = 'AJUSTE_PROVEEDOR',
            active = 1
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':equipment_id' => $equipment_id,
        ':provider_id' => $provider_id,
        ':operation_id' => $operation_id,
        ':business_id' => $business_id,
        ':site_id' => $site_id,
        ':period_year' => $year,
        ':period_month' => $month,
        ':monthly_cost' => $monthly_cost,
        ':contracted_hours' => $contracted_hours,
        ':adjustment_id' => $adjustment_id,
        ':created_by' => $created_by
    ]);
}

function getMonthsBetweenPeriods(
    int $start_year,
    int $start_month,
    int $end_year,
    int $end_month
): array
{
    $months = [];

    $current = new DateTime(
        sprintf(
            '%04d-%02d-01',
            $start_year,
            $start_month
        )
    );

    $end = new DateTime(
        sprintf(
            '%04d-%02d-01',
            $end_year,
            $end_month
        )
    );

    while ($current <= $end) {

        $months[] = [
            'year' => (int) $current->format('Y'),
            'month' => (int) $current->format('m')
        ];

        $current->modify('+1 month');
    }

    return $months;
}