<?php

require_once '../../config/database.php';

function getOperationById(
    PDO $conexion,
    int $id
): array|false
{
    $sql = "
        SELECT *
        FROM operations
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function operationExists(
    PDO $conexion,
    string $name
): bool
{
    $sql = "
        SELECT id
        FROM operations
        WHERE name = :name
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name
    ]);

    return (bool) $stmt->fetch();
}

function operationExistsForAnotherId(
    PDO $conexion,
    string $name,
    int $id
): bool
{
    $sql = "
        SELECT id
        FROM operations
        WHERE name = :name
        AND id <> :id
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':id'   => $id
    ]);

    return (bool) $stmt->fetch();
}

function createOperation(
    PDO $conexion,
    string $name,
    int $site_id,
    int $business_id
): bool
{
    $sql = "
        INSERT INTO operations
        (
            name,
            site_id,
            business_id
        )
        VALUES
        (
            :name,
            :site_id,
            :business_id
        )
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name'        => $name,
        ':site_id'     => $site_id,
        ':business_id' => $business_id
    ]);
}

function updateOperation(
    PDO $conexion,
    int $id,
    string $name
): bool
{
    $sql = "
        UPDATE operations
        SET name = :name
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':id'   => $id
    ]);
}