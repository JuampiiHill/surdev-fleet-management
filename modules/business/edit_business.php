<?php

require_once '../../middleware/auth.php';
require_once 'BusinessController.php';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = (int) $_POST['id'];

        $name = strtoupper(
            trim($_POST['name'])
        );

        if (
            $id <= 0 ||
            empty($name)
        ) {

            throw new Exception(
                'Datos inválidos.'
            );
        }

        if (
            businessExistsForAnotherId(
                $conexion,
                $name,
                $id
            )
        ) {

            throw new Exception(
                'Ya existe un negocio con ese nombre.'
            );
        }

        updateBusiness(
            $conexion,
            $id,
            $name
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

    $business = getBusinessById(
        $conexion,
        $id
    );

    if (!$business) {

        throw new Exception(
            'Negocio inexistente.'
        );
    }

} catch (Exception $e) {

    error_log(
        'Error edit_business: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar el negocio.'
    );
}
?>


<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar negocio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h3 class="mb-4">
                Editar negocio
            </h3>

            <form method="POST">
                <input type="hidden"
                       name="id"
                       value="<?php echo $business['id']; ?>">
                <div class="mb-3">
                    <label class="form-label">
                        Tipo
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?php echo $business['name']; ?>"
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