<?php

function recalculateEquipmentHourmeter(
    PDO $conexion,
    int $equipment_id
): void
{
    $sql = "
        SELECT
            GREATEST(
                COALESCE(e.initial_hourmeter, 0),
                COALESCE((
                    SELECT MAX(ehl.hourmeter)
                    FROM equipment_hour_logs ehl
                    WHERE ehl.equipment_id = e.id
                ), 0),
                COALESCE((
                    SELECT MAX(em.hourmeter)
                    FROM equipment_maintenances em
                    WHERE em.equipment_id = e.id
                    AND em.deleted_at IS NULL
                ), 0)
            ) AS calculated_hourmeter
        FROM equipments e
        WHERE e.id = :equipment_id
    ";

    $stmt =
        $conexion->prepare($sql);

    $stmt->execute([
        ':equipment_id' => $equipment_id
    ]);

    $calculated_hourmeter =
        $stmt->fetchColumn();

    if ($calculated_hourmeter === false) {
        return;
    }

    $sql_update = "
        UPDATE equipments
        SET current_hourmeter = :current_hourmeter
        WHERE id = :equipment_id
    ";

    $stmt_update =
        $conexion->prepare($sql_update);

    $stmt_update->execute([
        ':current_hourmeter' => $calculated_hourmeter,
        ':equipment_id' => $equipment_id
    ]);
}