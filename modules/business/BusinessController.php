<?php

require_once '../../config/database.php';

function getBusinessById(
    PDO $conexion,
    int $id
)
{
    $sql = "
        SELECT *
        FROM businesses
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch();
}

function businessExists(
    PDO $conexion,
    string $name
)
{
    $sql = "
        SELECT id
        FROM businesses
        WHERE name = :name
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':name' => $name
    ]);

    return $stmt->fetch();
}

function businessExistsForAnotherId(
    PDO $conexion,
    string $name,
    int $id
)
{
    $sql = "
        SELECT id
        FROM businesses
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

function createBusiness(
    PDO $conexion,
    string $name
)
{
    $sql = "
        INSERT INTO businesses
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

function updateBusiness(
    PDO $conexion,
    int $id,
    string $name
)
{
    $sql = "
        UPDATE businesses
        SET name = :name
        WHERE id = :id
    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':id' => $id
    ]);
}
?>
