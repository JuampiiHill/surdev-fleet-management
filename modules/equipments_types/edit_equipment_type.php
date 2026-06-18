<?php

require_once '../../middleware/auth.php';
require_once 'EquipmentTypeController.php';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = (int) $_POST['id'];

        $type = strtoupper(
            trim($_POST['type'])
        );

        if (
            $id <= 0 ||
            empty($type)
        ) {

            throw new Exception(
                'Datos inválidos.'
            );
        }

        if (
            equipmentTypeExistsForAnotherId(
                $conexion,
                $type,
                $id
            )
        ) {

            throw new Exception(
                'Ya existe un tipo con ese nombre.'
            );
        }

        updateEquipmentType(
            $conexion,
            $id,
            $type
        );

        header(
            'Location: ../../views/settings/settings.php'
        );

        exit;
    }

    if (!isset($_GET['id'])) {

        header(
            'Location: ../../views/settings/settings.php'
        );

        exit;
    }

    $id = (int) $_GET['id'];

    $equipment_type = getEquipmentTypeById(
        $conexion,
        $id
    );

    if (!$equipment_type) {

        throw new Exception(
            'Tipo inexistente.'
        );
    }

} catch (Exception $e) {

    error_log(
        'Error edit_equipment_type: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar el tipo.'
    );
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar tipo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h3 class="mb-4">
                Editar tipo de equipo
            </h3>

            <form method="POST">
                <input type="hidden"
                       name="id"
                       value="<?php echo $equipment_type['id']; ?>">
                <div class="mb-3">
                    <label class="form-label">
                        Tipo
                    </label>

                    <input type="text"
                           name="type"
                           class="form-control"
                           value="<?php echo $equipment_type['type']; ?>"
                           required>
                </div>

                <button class="btn btn-primary">
                    Guardar cambios
                </button>

                <a href="../../views/settings/settings.php"
                   class="btn btn-secondary">
                    Volver
                </a>
            </form>
        </div>
    </div>
</div>
</body>
</html>