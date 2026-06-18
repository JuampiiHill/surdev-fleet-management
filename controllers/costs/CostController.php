<?php

require_once '../../config/database.php';

function uploadCostFile(
    array $file
): ?string
{
    if (
        empty($file) ||
        $file['error'] !== 0
    ) {
        return null;
    }

    $allowed = [
        'pdf',
        'jpg',
        'jpeg',
        'png'
    ];

    $extension = strtolower(
        pathinfo(
            $file['name'],
            PATHINFO_EXTENSION
        )
    );

    if (
        !in_array(
            $extension,
            $allowed
        )
    ) {

        throw new Exception(
            'Tipo de archivo no permitido.'
        );
    }

    $upload_dir =
        '../../assets/uploads/costs/';

    if (!is_dir($upload_dir)) {

        mkdir(
            $upload_dir,
            0755,
            true
        );
    }

    $file_name =
        uniqid('cost_')
        . '.'
        . $extension;

    if (
        !move_uploaded_file(
            $file['tmp_name'],
            $upload_dir . $file_name
        )
    ) {

        throw new Exception(
            'No se pudo guardar el archivo.'
        );
    }

    return $file_name;
}

function createCost(
    PDO $conexion,
    int $equipment_id,
    string $cost_date,
    string $cost_type,
    string $description,
    float $amount,
    ?string $file_name
): bool
{
    $sql = "

        INSERT INTO equipment_costs
        (
            equipment_id,
            cost_date,
            cost_type,
            description,
            amount,
            file
        )
        VALUES
        (
            :equipment_id,
            :cost_date,
            :cost_type,
            :description,
            :amount,
            :file
        )

    ";

    $stmt = $conexion->prepare($sql);

    return $stmt->execute([
        ':equipment_id' => $equipment_id,
        ':cost_date'    => $cost_date,
        ':cost_type'    => $cost_type,
        ':description'  => $description,
        ':amount'       => $amount,
        ':file'         => $file_name
    ]);
}