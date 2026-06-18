<?php

require_once '../../config/database.php';

function getSiteById(PDO $conexion, int $id)
{
    $sql = "
        SELECT *
        FROM sites
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function siteExists(
    PDO $conexion,
    string $name
)
{
    $sql = "
        SELECT id
        FROM sites
        WHERE name = :name
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name
    ]);

    return $stmt->fetch();
}

function siteExistsForAnotherId(
    PDO $conexion,
    string $name,
    int $id
)
{
    $sql = "
        SELECT id
        FROM sites
        WHERE name = :name
        AND id <> :id
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function createSite(
    PDO $conexion,
    string $name
)
{
    $sql = "
        INSERT INTO sites
        (
            name
        )
        VALUES
        (
            :name
        )
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name' => $name
    ]);
}

function updateSite(
    PDO $conexion,
    int $id,
    string $name
)
{
    $sql = "
        UPDATE sites
        SET name = :name
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':id' => $id
    ]);
}