<?php

require_once '../../config/database.php';

function getProviderById(PDO $conexion, int $id)
{
    $sql = "
        SELECT *
        FROM providers
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function providerExists(PDO $conexion, string $name)
{
    $sql = "
        SELECT id
        FROM providers
        WHERE name = :name
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name
    ]);

    return $stmt->fetch();
}

function createProvider(
    PDO $conexion,
    string $name
)
{
    $sql = "
        INSERT INTO providers
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

function updateProvider(
    PDO $conexion,
    int $id,
    string $name
)
{
    $sql = "
        UPDATE providers
        SET name = :name
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':id' => $id
    ]);
}