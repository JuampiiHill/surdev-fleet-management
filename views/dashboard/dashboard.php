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
                    <option>Todas las operaciones</option>
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
                    <option>Todos los proveedores</option>
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

            <button class="btn btn-outline-success"
            data-bs-toggle="modal"
            data-bs-target="#createOperationModal">
                Nueva Operacion
            </button>

            <button class="btn btn-outline-warning"
            data-bs-toggle="modal"
            data-bs-target="#createSiteModal">
                Nuevo Site
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
                    <th>Anio</th>
                    <th>Hs Contratadas</th>
                    <th>Negocio</th>
                    <th>ID</th>
                    <th>Costo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($equipments as $equipment): ?>

                <tr onclick="window.location.href='../equipments/equipment_detail.php?id=<?php echo $equipment['id']; ?>'">
                    <td>Makro</td>
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
                <?php endforeach; ?>                    

                </tbody>
        </table>
    </div>
</div>

<!-- MODAL NUEVA OPERACION -->

<div class="modal fade" id="createOperationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Nueva Operacion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../operations/store_operation.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Nombre operacion
                        </label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Site
                        </label>

                        <select name="site_id" class="form-select" required>
                            <option value="">
                                Seleccionar
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Negocio
                        </label>
                        
                        <select name="business_id" class="form-select" required>
                            <option value="">
                                Seleccionar
                            </option>
                        </select>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
                </div>


                <!-- MODAL NUEVO SITE -->

<div class="modal fade" id="createSiteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Nuevo Site
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../../modules/store_site.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Nombre site
                        </label>
                        <input type="text" name="site" class="form-control" required>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php include '../../includes/footer.php';?>