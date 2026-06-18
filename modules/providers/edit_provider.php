<?php

require_once '../../middleware/auth.php';
require_once 'ProviderController.php';

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

        updateProvider(
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

    $provider = getProviderById(
        $conexion,
        $id
    );

    if (!$provider) {

        throw new Exception(
            'Proveedor inexistente.'
        );
    }

} catch (Exception $e) {

    error_log(
        'Error edit_provider: '
        . $e->getMessage()
    );

    die(
        'Ocurrió un error al cargar el proveedor.'
    );
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar Proveedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h3 class="mb-4">
                Editar proveedor
            </h3>

            <form method="POST">
                <input type="hidden"
                       name="id"
                       value="<?php echo $provider['id']; ?>">
                <div class="mb-3">
                    <label class="form-label">
                        Tipo
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?php echo $provider['name']; ?>"
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