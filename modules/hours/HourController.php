<?php

function getEquipmentById(
    PDO $conexion,
    int $equipment_id
): array|false
{
    $sql = "
        SELECT
            id,
            internal_number,
            brand,
            model,
            current_hourmeter
        FROM equipments
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $equipment_id
    ]);

    return $stmt->fetch();
}

function createHourLog(
    PDO $conexion,
    int $equipment_id,
    string $work_date,
    float $hours,
    float $hourmeter,
    string $observations,
    ?int $user_id
): bool
{
    $sql = "
        INSERT INTO equipment_hour_logs
        (
            equipment_id,
            work_date,
            hours,
            hourmeter,
            observations,
            created_by
        )
        VALUES
        (
            :equipment_id,
            :work_date,
            :hours,
            :hourmeter,
            :observations,
            :created_by
        )
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':equipment_id' => $equipment_id,
        ':work_date' => $work_date,
        ':hours' => $hours,
        ':hourmeter' => $hourmeter,
        ':observations' => $observations,
        ':created_by' => $user_id
    ]);
}

function updateEquipmentHourmeter(
    PDO $conexion,
    int $equipment_id,
    float $hourmeter
): bool
{
    $sql = "
        UPDATE equipments
        SET current_hourmeter = :hourmeter
        WHERE id = :equipment_id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':hourmeter' => $hourmeter,
        ':equipment_id' => $equipment_id
    ]);
}