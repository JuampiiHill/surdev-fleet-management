<?php

require_once '../../config/database.php';

function getEquipmentTypeById(
    PDO $conexion,
    int $id
)
{
    $sql = "
        SELECT *
        FROM equipments_types
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function equipmentTypeExists(
    PDO $conexion,
    string $type
)
{
    $sql = "
        SELECT id
        FROM equipments_types
        WHERE type = :type
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':type' => $type
    ]);

    return $stmt->fetch();
}

function equipmentTypeExistsForAnotherId(
    PDO $conexion,
    string $type,
    int $id
)
{
    $sql = "
        SELECT id
        FROM equipments_types
        WHERE type = :type
        AND id <> :id
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':type' => $type,
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function createEquipmentType(
    PDO $conexion,
    string $type
)
{
    $sql = "
        INSERT INTO equipments_types
        (
            type
        )
        VALUES
        (
            :type
        )
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':type' => $type
    ]);
}

function updateEquipmentType(
    PDO $conexion,
    int $id,
    string $type
)
{
    $sql = "
        UPDATE equipments_types
        SET type = :type
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':type' => $type,
        ':id' => $id
    ]);
}

function deleteEquipmentType(
    PDO $conexion,
    int $id
)
{
    $sql = "
        DELETE FROM equipments_types
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':id' => $id
    ]);
}