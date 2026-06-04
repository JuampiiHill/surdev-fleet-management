<?php

session_start();

require_once '../../config/database.php';

if(!isset($_GET['id'])){
    header('Location: ../dashboard/dashboard.php');
    exit;
}

$equipment_id = $_GET['id'];

$sql = "
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

    WHERE e.id = :id
";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $equipment_id);
$stmt->execute();

$equipment = $stmt->fetch();

if(!$equipment){
    header('Location: ../dashboard/dashboard.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| OPERACIONES
|--------------------------------------------------------------------------
*/

$sql_operations = "
    SELECT
        o.id,
        o.name,
        s.name AS site_name
    FROM operations o
    LEFT JOIN sites s
        ON o.site_id = s.id
    WHERE o.active = 1
    ORDER BY o.name
";

$stmt_operations = $conexion->prepare($sql_operations);
$stmt_operations->execute();

$operations = $stmt_operations->fetchAll();

/*
|--------------------------------------------------------------------------
| ULTIMO MANTENIMIENTO
|--------------------------------------------------------------------------
*/

$sql_last_maintenance = "
    SELECT *
    FROM equipment_maintenances
    WHERE equipment_id = :equipment_id
    ORDER BY maintenance_date DESC, id DESC
    LIMIT 1
";

$stmt_last_maintenance = $conexion->prepare($sql_last_maintenance);

$stmt_last_maintenance->execute([
    ':equipment_id' => $equipment_id
]);

$last_maintenance = $stmt_last_maintenance->fetch();

/*
|--------------------------------------------------------------------------
| CALCULO MANTENIMIENTO
|--------------------------------------------------------------------------
*/

$intervalo = $equipment['maintenance_interval_hours'];

$horometro_actual = $equipment['current_hourmeter'];

if($last_maintenance){

    $ultimo_mantenimiento_hs =
        $last_maintenance['hourmeter'];

}else{

    $ultimo_mantenimiento_hs =
        $equipment['initial_hourmeter'];
}

$proximo_mantenimiento =
    $ultimo_mantenimiento_hs +
    $intervalo;

$horas_consumidas =
    $horometro_actual -
    $ultimo_mantenimiento_hs;

$horas_restantes =
    $proximo_mantenimiento -
    $horometro_actual;

$porcentaje = 0;

if($intervalo > 0){

    $porcentaje =
        ($horas_consumidas * 100)
        / $intervalo;
}

if($porcentaje > 100){

    $porcentaje = 100;
}

$color_grafico = '#2563eb';
$estado_mantenimiento = 'VIGENTE';

if($horas_restantes <= 0){

    $color_grafico = '#dc2626';
    $estado_mantenimiento = 'VENCIDO';

}
elseif($horas_restantes <= 50){

    $color_grafico = '#f59e0b';
    $estado_mantenimiento = 'PRÓXIMO A VENCER';
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="main-content equipment-detail-layout">

    <div class="detail-topbar">

        <a
            href="../dashboard/dashboard.php"
            class="detail-back-link"
        >
            <i class="bi bi-arrow-left"></i>
            Volver al listado
        </a>

        <div class="user-info">

            <div class="avatar">
                <?php echo strtoupper(substr($_SESSION['user'],0,1)); ?>
            </div>

            <div>
                <strong>
                    <?php echo $_SESSION['user']; ?>
                </strong>

                <p class="mb-0">
                    <?php echo $_SESSION['rol']; ?>
                </p>
            </div>

        </div>

    </div>

    <!-- HEADER -->

    <div class="equipment-header-bar">

        <div class="equipment-header-left">

            <h1>
                Equipo: <?php echo $equipment['internal_number']; ?>
            </h1>

            <span class="equipment-subtitle">
                <?php echo strtoupper($equipment['equipment_type']); ?>
            </span>

            <?php if(!empty($equipment['status_name'])): ?>

                <span class="equipment-status-badge">
                    <?php echo strtoupper($equipment['status_name']); ?>
                </span>

            <?php endif; ?>

        </div>

        <div class="equipment-header-actions">

            <a href="../../modules/hours/register-hours.php?equipment_id=<?php echo $equipment['id']; ?>"class="btn btn-primary">
                Registrar Horas
            </a>

            <button class="btn btn-outline-success">
                Nueva OR
            </button>

            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#preventiveModal">
                Registrar Preventivo
            </button>

            <button class="btn btn-outline-danger">
                Indisponibilidad
            </button>

        </div>

    </div>

    <div class="detail-content">

        <div class="equipment-top-grid">

            <div class="detail-card">

                <h3 class="card-title">
                    Información General
                </h3>

                <div class="info-card-content">

                    <div>

                        <div class="info-row">
                            <span>Interno</span>
                            <strong><?php echo $equipment['internal_number']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Tipo</span>
                            <strong><?php echo $equipment['equipment_type']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Marca</span>
                            <strong><?php echo $equipment['brand']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Modelo</span>
                            <strong><?php echo $equipment['model']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Año</span>
                            <strong><?php echo $equipment['year']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>N° Serie</span>
                            <strong><?php echo $equipment['serial_number']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Valor de alquiler</span>
                            <strong><?php echo $equipment['provider_name']; ?></strong>
                        </div>

                    </div>

                    <div class="equipment-image-box">

                        <?php if(!empty($equipment['image'])): ?>

                            <img
                                src="/surdev/assets/uploads/equipments/<?php echo $equipment['image']; ?>"
                                alt="Equipo"
                            >

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <div class="detail-card">

                <h3 class="card-title">
                    Ubicación Actual
                </h3>

                <div class="location-row">
                    <span>Operación</span>
                    <strong><?php echo $equipment['operation_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Site</span>
                    <strong><?php echo $equipment['site_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Negocio</span>
                    <strong><?php echo $equipment['business_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Proveedor</span>
                    <strong><?php echo $equipment['provider_name']; ?></strong>
                </div>

                <div class="mt-4">

                    <button
                        class="btn btn-outline-primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#changeLocationModal">
                            Cambiar Operación / Site
                    </button>

                </div>

            </div>

            <div class="detail-card">

                <h3 class="card-title">
                    Horas y Mantenimiento
                </h3>

                <div class="maintenance-content">

                    <div class="maintenance-gauge">

                        <div
                            class="progress-ring"
                            style="
                                background:
                                conic-gradient(
                                <?php echo $color_grafico; ?> <?php echo $porcentaje; ?>%,
                                #e5e7eb <?php echo $porcentaje; ?>%
                            );
                            "
                        >

                            <div class="progress-inner">
                                <?php echo round($porcentaje); ?>%
                            </div>

                        </div>

                    </div>

                    <div class="maintenance-data">

                        <div class="location-row">
                            <span>Ciclo Preventivo</span>
                            <strong>
                                <?php echo $intervalo; ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Horometro actual</span>
                            <strong>
                                <?php echo number_format($horometro_actual,0,',','.'); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Horas restantes</span>
                            <strong>
                                <?php echo $horas_restantes; ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Último mantenimiento</span>
                            <strong>
                                <?php echo number_format(
                                    $ultimo_mantenimiento_hs,
                                    0,
                                    ',',
                                    '.'
                                    ); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Próximo mantenimiento</span>
                            <strong>
                                <?php echo number_format(
                                    $proximo_mantenimiento,
                                    0,
                                    ',',
                                    '.'
                                ); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Estado</span>

                            <strong class="maintenance-ok">
                                <?php echo $estado_mantenimiento; ?>
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==============
MODAL PREVENTIVO
=================-->

<div
    class="modal fade"
    id="preventiveModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/maintenances/create_maintenance.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Registrar Mantenimiento Preventivo
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong>Equipo:</strong>

                        <?php echo $equipment['internal_number']; ?>

                        -

                        <?php echo $equipment['brand']; ?>

                        <?php echo $equipment['model']; ?>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Fecha mantenimiento
                            </label>

                            <input
                                type="date"
                                name="maintenance_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Horómetro al realizar mantenimiento
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="hourmeter"
                                class="form-control"
                                value="<?php echo $equipment['current_hourmeter']; ?>"
                                required
                            >

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OT / Informe / PDF
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
                            rows="4"
                            class="form-control"
                        ></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Guardar Preventivo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ==========================
MODAL CAMBIO OPERACION
========================== -->

<div
    class="modal fade"
    id="changeLocationModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/equipments/change_location.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cambiar Operación / Site
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong>Ubicación actual:</strong>

                        <br>

                        <?php echo $equipment['operation_name']; ?>

                        -

                        <?php echo $equipment['site_name']; ?>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Nueva Operación
                        </label>

                        <select
                            name="operation_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccionar
                            </option>

                            <?php foreach($operations as $operation): ?>

                                <option
                                    value="<?php echo $operation['id']; ?>"
                                >
                                    <?php echo $operation['name']; ?>
                                    -
                                    <?php echo $operation['site_name']; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
                            rows="3"
                            class="form-control"
                        ></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Guardar Movimiento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>