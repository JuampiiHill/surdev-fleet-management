<?php

session_start();

require_once '../../config/database.php';

$page_title = "Configuraciones";

include '../../includes/header.php';
include '../../includes/sidebar.php';

// ----- Obtener sites ---------
$sql_sites = "SELECT * FROM sites ORDER BY name ASC";

$stmt_sites = $conexion->prepare($sql_sites);
$stmt_sites->execute();

$sites = $stmt_sites->fetchAll();

// ----- Obtener negocios ---------
$sql_business = "SELECT * FROM businesses ORDER BY name ASC";

$stmt_business = $conexion->prepare($sql_business);
$stmt_business->execute();

$business = $stmt_business->fetchAll();

//----- Obtener tipo de equipos ---------
$sql_equipment_types = "SELECT * FROM equipments_types ORDER BY type ASC";

$stmt_equipment_types = $conexion->prepare($sql_equipment_types);

$stmt_equipment_types->execute();

$equipment_types = $stmt_equipment_types->fetchAll();

?>

<div class = "main-content">
    <?php include '../../includes/topbar.php'; ?>

    <div class="settings-grid">

        <div class="settings-card">
            <div class="settings-icon">
                <i class="bi bi-building"></i>
            </div>

            <h3>Operaciones</h3>

            <p>
                Agrega y administra operaciones del sistema.
            </p>

            <button class="btn btn-primary" 
            data-bs-toggle="modal" 
            data-bs-target="#createOperationModal">
                Nueva operación
            </button>
        </div>

        <div class="settings-card">
            <div class="settings-icon">
                <i class="bi bi-geo-alt"></i>
            </div>

            <h3>Sites</h3>

            <p>
                Gestiona los sites operativos disponibles.
            </p>

            <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createSiteModal">
                Nuevo site
            </button>
        </div>

        <div class="settings-card">
            <div class="settings-icon">
                <i class="bi bi-people"></i>
            </div>

            <h3>Proveedores</h3>

            <p>
                Administra proveedores y contratistas.
            </p>

            <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createProviderModal">
                Nuevo proveedor
            </button>
        </div>

        <div class="settings-card">
            <div class="settings-icon">
                <i class="bi bi-truck"></i>
            </div>

            <h3>Tipos de equipos</h3>

            <p>
                Configura categorías de equipos industriales.
            </p>

            <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#equipmentTypeModal">
                Administrar tipos
            </button>
        </div>

        <div class="settings-card">
            <div class="settings-icon">
                <i class="bi bi-person-gear"></i>
            </div>

            <h3>Usuario</h3>

            <p>
                Cambia contraseña y preferencias de cuenta.
            </p>

            <button class="btn btn-primary">
                Configurar usuario
            </button>
        </div>

    </div>

</div>

<?php include '../../includes/modals/modal_operation.php'; ?>

<?php include '../../includes/modals/modal_site.php'; ?>

<?php include '../../includes/modals/modal_provider.php'; ?>

<?php include '../../includes/modals/modal_equipment_type.php'; ?>

<?php include '../../includes/footer.php'; ?>