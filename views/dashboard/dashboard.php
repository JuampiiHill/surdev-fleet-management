<?php

session_start();

require_once '../../config/database.php';

$page_title = "Listado de equipos";

include '../../includes/header.php';
include '../../includes/sidebar.php';


/* GET EQUIPMENTS */

$sql_eq = "
    SELECT
        e.*,
        o.name AS operation_name,
        s.name AS site_name,
        b.name AS business_name,
        p.name AS provider_name,
        et.type AS equipment_type,
        es.name AS status_name

    FROM equipments e

    LEFT JOIN operations o
        ON e.operation_id = o.id

    LEFT JOIN sites s
        ON e.site_id = s.id

    LEFT JOIN businesses b
        ON e.business_id = b.id

    LEFT JOIN providers p
        ON e.provider_id = p.id

    LEFT JOIN equipments_types et
        ON e.equipment_type_id = et.id

    LEFT JOIN equipment_statuses es
        ON e.status_id = es.id

    WHERE e.active = 1

    ORDER BY e.id DESC
";

$stmt_eq = $conexion->prepare($sql_eq);
$stmt_eq->execute();

$equipments = $stmt_eq->fetchAll();


/* GET STATUSES */

$sql_status = "
    SELECT *
    FROM equipment_statuses
";

$stmt_status = $conexion->prepare($sql_status);
$stmt_status->execute();

$statuses = $stmt_status->fetchAll();


/* GET EQUIPMENT TYPES */

$sql_eqt = "
    SELECT *
    FROM equipments_types
    ORDER BY type ASC
";

$stmt_eqt = $conexion->prepare($sql_eqt);
$stmt_eqt->execute();

$equipments_types = $stmt_eqt->fetchAll();


/* GET SITES */

$sql_sites = "
    SELECT *
    FROM sites
    ORDER BY name ASC
";

$stmt_sites = $conexion->prepare($sql_sites);
$stmt_sites->execute();

$sites = $stmt_sites->fetchAll();


/* GET BUSINESS */

$sql_business = "
    SELECT *
    FROM businesses
    ORDER BY name ASC
";

$stmt_business = $conexion->prepare($sql_business);
$stmt_business->execute();

$business = $stmt_business->fetchAll();


/* GET PROVIDERS */

$sql_providers = "
    SELECT *
    FROM providers
    ORDER BY name ASC
";

$stmt_provider = $conexion->prepare($sql_providers);
$stmt_provider->execute();

$providers = $stmt_provider->fetchAll();


/* GET OPERATIONS */

$sql_op = "
    SELECT *
    FROM operations
    ORDER BY name ASC
";

$stmt_op = $conexion->prepare($sql_op);
$stmt_op->execute();

$operations = $stmt_op->fetchAll();

?>

<div class="main-content">

    <?php include '../../includes/topbar.php'; ?>

    <div class="dashboard-card">
        <div class="equipment-header">
            <div class="equipment-title">

                <h2>
                    Gestión general de equipos
                </h2>
            </div>

            <div class="header-actions">

                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createEquipmentModal"
                >
                    + Nuevo equipo
                </button>

                <button class="btn btn-outline-secondary">
                    Exportar
                </button>
            </div>
        </div>
        <div class="filters">
            <div>

                <label class="filter-label">
                    Operación
                </label>

                <select class="form-select">

                    <option value="">
                        Todas las operaciones
                    </option>

                    <?php foreach($operations as $op): ?>

                        <option value="<?php echo $op['id']; ?>">
                            <?php echo $op['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Negocio
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los negocios
                    </option>

                    <?php foreach($business as $b): ?>

                        <option value="<?php echo $b['id']; ?>">
                            <?php echo $b['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Site
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los sites
                    </option>

                    <?php foreach($sites as $site): ?>

                        <option value="<?php echo $site['id']; ?>">
                            <?php echo $site['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Proveedor
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los proveedores
                    </option>

                    <?php foreach($providers as $p): ?>

                        <option value="<?php echo $p['id']; ?>">
                            <?php echo $p['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Estado
                </label>

                <select class="form-select">

                    <option value="">
                        Todos
                    </option>

                    <?php foreach($statuses as $status): ?>

                        <option value="<?php echo $status['id']; ?>">
                            <?php echo $status['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Buscar
                </label>

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar equipo..."
                >
            </div>
        </div>
        
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Operación</th>
                        <th>Tipo</th>
                        <th>Modelo</th>
                        <th>Proveedor</th>
                        <th>Año</th>
                        <th>Hs Contratadas</th>
                        <th>Negocio</th>
                        <th>Interno</th>
                        <th>Costo</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($equipments as $equipment): ?>
                        <tr onclick="window.location.href='../equipments/equipment_detail.php?id=<?php echo $equipment['id']; ?>'">

                            <td>
                                <?php echo $equipment['operation_name']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['equipment_type']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['brand']; ?>
                                <?php echo $equipment['model']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['provider_name']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['year']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['contracted_hours']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['business_name']; ?>
                            </td>

                            <td>
                                <?php echo $equipment['internal_number']; ?>
                            </td>

                            <td>
                                $
                                <?php echo number_format(
                                    $equipment['monthly_cost'],
                                    2,
                                    ',',
                                    '.'
                                ); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/modals/modal_operation.php'; ?>

<?php include '../../includes/modals/modal_site.php'; ?>

<?php include '../../includes/modals/modal_provider.php'; ?>

<?php include '../../includes/modals/modal_equipment.php'; ?>

<?php include '../../includes/footer.php'; ?>