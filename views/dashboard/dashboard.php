<?php

session_start();
require_once '../../config/database.php';

$page_title = "Listado de equipos";

include '../../includes/header.php';
include '../../includes/sidebar.php';

// Obtener equipos
$sql_eq = "SELECT * FROM equipments";

$stmt_eq = $conexion->prepare($sql_eq);
$stmt_eq-> execute();

$equipments = $stmt_eq->fetchAll();

// ----- Obtener sites ---------
$sql_sites = "SELECT * FROm sites ORDER BY name ASC";

$stmt_sites = $conexion->prepare($sql_sites);
$stmt_sites->execute();

$sites = $stmt_sites->fetchAll();

// ----- Obtener negocios ---------
$sql_business = "SELECT * FROm businesses ORDER BY name ASC";

$stmt_business = $conexion->prepare($sql_business);
$stmt_business->execute();

$business = $stmt_business->fetchAll();

// ----- Obtener proveedores ---------
$sql_providers = "SELECT * FROM providers ORDER BY name ASC";

$stmt_provider = $conexion->prepare($sql_providers);
$stmt_provider->execute();

$providers = $stmt_provider->fetchAll();

// ----- Obtener operaciones ---------
$sql_op = "SELECT * FROM operations ORDER BY name ASC";

$stmt_op = $conexion->prepare($sql_op);
$stmt_op->execute();

$operations = $stmt_op->fetchAll();
?>


<div class="main-content">
    
    <?php include '../../includes/topbar.php'; ?>

    <div class="dashboard-card">
        <h2 class="mb-4">
            Listado de equipos
        </h2>

        <div class="filters">
            <div>
                <label class="filter-label">
                    Operacion
                </label>

                <select class="form-select">
                    <option value="">
                        Todas los negocios
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
                        Todas los negocios
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
                        Todas los sites
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
                        Todas los sites
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
                    <option>Todas</option>
                </select>
            </div>
            <div>
                <label class="filter-label">
                    Buscar
                </label>
                <input type="text" class="form-control" placeholder="Buscar equipo...">
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-primary">
                Nuevo equipo
            </button>

            <button class="btn btn-outline-danger">
                Indisponibilidad
            </button>

        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>Operacion</th>
                    <th>Tipo</th>
                    <th>Modelo</th>
                    <th>Proveedor</th>
                    <th>Año</th>
                    <th>Hs Contratadas</th>
                    <th>Negocio</th>
                    <th>ID</th>
                    <th>Costo</th>
                </tr>
            </thead>

            <tbody>
                <td>Jaguar</td>
                <td>Autoelevador</td>
                <td>8FG25</td>
                <td>Montacargas SRL</td>
                <td>2026</td>
                <td>250</td>
                <td>Consumo Masivo</td>
                <td>5511</td>
                <td>$ 1.932.134,74</td>

                <tr>
                    <td>Jaguar</td>
                    <td>Zorra HB</td>
                    <td>LPE200</td>
                    <td>Logística del Sur</td>
                    <td>2025</td>
                    <td>250</td>
                    <td>Consumo Masivo</td>
                    <td>EQ001</td>
                    <td>$ 932.134,74</td>
                </tr>
                <!-- <?php foreach($equipments as $equipment): ?>

                <tr onclick="window.location.href='../equipments/equipment_detail.php?id=<?php echo $equipment['id']; ?>'">
                    <td>
                        <?php echo $equipment['model']; ?>
                    </td>
                    <td>
                        <?php echo $equipment['year']; ?>            
                    </td>
                    <td>
                        <?php echo $equipment['id']; ?>
                    </td>
                </tr>
                <?php endforeach; ?> -->         

            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/modals/modal_operation.php'; ?>

<?php include '../../includes/modals/modal_site.php'; ?>

<?php include '../../includes/modals/modal_provider.php'; ?>

<?php include '../../includes/footer.php';?>