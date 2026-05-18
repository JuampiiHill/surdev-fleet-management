<?php

session_start();

require_once '../../config/database.php';

$page_title = "Configuraciones";

include '../../includes/header.php';
include '../../includes/sidebar.php';

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

            <button class="btn btn-primary">
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

            <button class="btn btn-primary">
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

            <button class="btn btn-primary">
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

            <button class="btn btn-primary">
                Nuevo tipo
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