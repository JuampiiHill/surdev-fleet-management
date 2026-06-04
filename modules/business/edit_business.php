<?php

require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $name = strtoupper($name);

    try {
        $sql = "UPDATE businesses
                SET name = :name
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('Location: ../../views/settings/settings.php');

        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * 
            FROM businesses
            WHERE id = :id";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $business = $stmt->fetch();
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