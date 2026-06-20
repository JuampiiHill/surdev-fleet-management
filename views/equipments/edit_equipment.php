<?php

require_once '../../middleware/auth.php';
require_once '../../config/database.php';

$page_title = 'Editar equipo';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../dashboard/dashboard.php');
    exit;
}

$equipment_id = (int) $_GET['id'];

try {

    $stmt = $conexion->prepare("
        SELECT *
        FROM equipments
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $equipment_id
    ]);

    $equipment = $stmt->fetch();

    if (!$equipment) {
        header('Location: ../dashboard/dashboard.php');
        exit;
    }

    $operations = $conexion->query("
        SELECT *
        FROM operations
        ORDER BY name ASC
    ")->fetchAll();

    $providers = $conexion->query("
        SELECT *
        FROM providers
        ORDER BY name ASC
    ")->fetchAll();

    $equipments_types = $conexion->query("
        SELECT *
        FROM equipments_types
        ORDER BY type ASC
    ")->fetchAll();

    $statuses = $conexion->query("
        SELECT *
        FROM equipment_statuses
        ORDER BY name ASC
    ")->fetchAll();

} catch (PDOException $e) {

    error_log('Error edit_equipment: ' . $e->getMessage());

    die('Ocurrió un error al cargar el equipo.');
}

include '../../partials/layout/app_header.php';

?>

<div class="main-content">

    <?php include '../../partials/layout/topbar.php'; ?>

    <div class="dashboard-card">

        <h2 class="mb-4">
            Editar equipo <?php echo $equipment['internal_number']; ?>
        </h2>

        <form
            action="../../controllers/equipments/update_equipment.php"
            method="POST"
            enctype="multipart/form-data">

            <input
                type="hidden"
                name="id"
                value="<?php echo $equipment['id']; ?>">

            <div class="row">

                <div class="col-md-3 mb-3">
                    <label class="form-label">Interno</label>
                    <input
                        type="text"
                        name="internal_number"
                        class="form-control"
                        value="<?php echo $equipment['internal_number']; ?>"
                        required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Marca</label>
                    <input
                        type="text"
                        name="brand"
                        class="form-control"
                        value="<?php echo $equipment['brand']; ?>">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Modelo</label>
                    <input
                        type="text"
                        name="model"
                        class="form-control"
                        value="<?php echo $equipment['model']; ?>"
                        required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Año</label>
                    <input
                        type="number"
                        name="year"
                        class="form-control"
                        value="<?php echo $equipment['year']; ?>">
                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Nº Serie</label>
                    <input
                        type="text"
                        name="serial_number"
                        class="form-control"
                        value="<?php echo $equipment['serial_number']; ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de equipo</label>
                    <select name="equipment_type_id" class="form-select" required>
                        <?php foreach ($equipments_types as $type): ?>
                            <option
                                value="<?php echo $type['id']; ?>"
                                <?php echo ($equipment['equipment_type_id'] == $type['id']) ? 'selected' : ''; ?>>
                                <?php echo $type['type']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Operación</label>
                    <select name="operation_id" class="form-select" required>
                        <?php foreach ($operations as $op): ?>
                            <option
                                value="<?php echo $op['id']; ?>"
                                <?php echo ($equipment['operation_id'] == $op['id']) ? 'selected' : ''; ?>>
                                <?php echo $op['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Proveedor</label>
                    <select name="provider_id" class="form-select" required>
                        <?php foreach ($providers as $provider): ?>
                            <option
                                value="<?php echo $provider['id']; ?>"
                                <?php echo ($equipment['provider_id'] == $provider['id']) ? 'selected' : ''; ?>>
                                <?php echo $provider['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status_id" class="form-select" required>
                        <?php foreach ($statuses as $status): ?>
                            <option
                                value="<?php echo $status['id']; ?>"
                                <?php echo ($equipment['status_id'] == $status['id']) ? 'selected' : ''; ?>>
                                <?php echo $status['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Cantidad baterías</label>
                    <input
                        type="number"
                        name="battery_quantity"
                        class="form-control"
                        value="<?php echo $equipment['battery_quantity']; ?>">
                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Hs contratadas</label>
                    <input
                        type="number"
                        name="contracted_hours"
                        class="form-control"
                        value="<?php echo $equipment['contracted_hours']; ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Costo mensual actual</label>
                    <input
                        type="number"
                        step="0.01"
                        name="monthly_cost"
                        class="form-control"
                        value="<?php echo $equipment['monthly_cost']; ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Intervalo mantenimiento</label>
                    <input
                        type="number"
                        name="maintenance_interval_hours"
                        class="form-control"
                        value="<?php echo $equipment['maintenance_interval_hours']; ?>">
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea
                    name="observations"
                    class="form-control"
                    rows="4"><?php echo $equipment['observations']; ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Cambiar imagen</label>
                <input
                    type="file"
                    name="image"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>

            <a
                href="../dashboard/dashboard.php"
                class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>

</div>

<?php include '../../partials/layout/app_footer.php'; ?>