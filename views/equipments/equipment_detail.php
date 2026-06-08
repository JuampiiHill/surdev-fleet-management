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

/* OPERACIONES*/

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

/* ULTIMO MANTENIMIENTO */

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

/* CALCULO MANTENIMIENTO */

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

/* GRAFICO USO MENSUAL */

$sql_chart = "
    SELECT
        MONTH(work_date) AS month_number,
        SUM(hours) AS total_hours
    FROM equipment_hour_logs
    WHERE equipment_id = :equipment_id
    GROUP BY MONTH(work_date)
    ORDER BY MONTH(work_date)
";

$stmt_chart = $conexion->prepare($sql_chart);

$stmt_chart->execute([
    ':equipment_id' => $equipment_id
]);

$chart_data = $stmt_chart->fetchAll();

$months = [
    'Ene',
    'Feb',
    'Mar',
    'Abr',
    'May',
    'Jun',
    'Jul',
    'Ago',
    'Sep',
    'Oct',
    'Nov',
    'Dic'
];

$chart_hours = array_fill(0, 12, 0);

foreach($chart_data as $row){

    $month_index =
        (int)$row['month_number'] - 1;

    $chart_hours[$month_index] =
        (float)$row['total_hours'];
}

/* ORDENES DE REPARACION */

$sql_repair_orders = "
    SELECT *
    FROM repair_orders
    WHERE equipment_id = :equipment_id
    ORDER BY report_date DESC
";

$stmt_repair_orders =
    $conexion->prepare($sql_repair_orders);

$stmt_repair_orders->execute([
    ':equipment_id' => $equipment_id
]);

$repair_orders =
    $stmt_repair_orders->fetchAll();

$sql_work_orders = "

    SELECT
        rwo.*,
        ro.order_number

    FROM repair_work_orders rwo

    INNER JOIN repair_orders ro
        ON rwo.repair_order_id = ro.id

    WHERE ro.equipment_id = :equipment_id

    ORDER BY rwo.work_date DESC

";

$stmt_work_orders =
    $conexion->prepare($sql_work_orders);

$stmt_work_orders->execute([
    ':equipment_id' => $equipment_id
]);

$work_orders =
    $stmt_work_orders->fetchAll();

$sql_preventives = "

    SELECT *
    FROM equipment_maintenances
    WHERE equipment_id = :equipment_id
    ORDER BY maintenance_date DESC

";

$stmt_preventives =
    $conexion->prepare($sql_preventives);

$stmt_preventives->execute([
    ':equipment_id' => $equipment_id
]);

$preventives =
    $stmt_preventives->fetchAll();

$sql_downtimes = "

    SELECT *
    FROM equipment_downtimes
    WHERE equipment_id = :equipment_id
    ORDER BY start_date DESC

";

$stmt_downtimes =
    $conexion->prepare($sql_downtimes);

$stmt_downtimes->execute([

    ':equipment_id' => $equipment_id

]);

$downtimes =
    $stmt_downtimes->fetchAll();

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

            <button
                class="btn btn-outline-success"
                data-bs-toggle="modal"
                data-bs-target="#repairOrderModal">
                    Nueva OR
            </button>

            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#preventiveModal">
                Registrar Preventivo
            </button>

            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#downtimeModal">
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
                            <span>Valor alquiler</span>
                            <strong>
                                $ <?php echo number_format(
                                    $equipment['monthly_cost'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </strong>
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

        <div class="detail-card mt-4">

    <ul
        class="nav nav-tabs mb-4"
        id="equipmentTabs"
        role="tablist"
    >

        <li class="nav-item">

            <button
                class="nav-link active"
                data-bs-toggle="tab"
                data-bs-target="#usage-tab"
            >
                Uso del Equipo
            </button>

        </li>

        <li class="nav-item">

            <button
                class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#or-tab"
            >
                Órdenes de Reparación
            </button>

        </li>

        <li class="nav-item">

            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ot-tab">
                Órdenes de Trabajo
            </button>

        </li>

        <li class="nav-item">

            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#preventive-tab">
                Preventivos
            </button>

        </li>

        <li class="nav-item">

            <button
                class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#downtime-tab"
            >
                Indisponibilidades
            </button>

        </li>

    </ul>

    <div class="tab-content">

        <!-- GRAFICO -->

        <div
            class="tab-pane fade show active"
            id="usage-tab">

            <div class="usage-header">

                <h5>
                    Gráfico de Uso
                </h5>

                <span class="usage-period">
                    Horas acumuladas por mes
                </span>

            </div>

        <div class="usage-chart-wrapper">

            <canvas id="equipmentUsageChart"></canvas>

        </div>

            </div>

                <!-- OR -->

                <div
                    class="tab-pane fade"
                    id="or-tab">

                    <?php if(count($repair_orders) > 0): ?>

                        <div class="table-responsive">

                            <table class="table repair-orders-table">

                                <thead>

                                    <tr>

                                        <th>OR</th>
                                        <th>Fecha</th>
                                        <th>Prioridad</th>
                                        <th>Reportado por</th>
                                        <th>Descripción de falla</th>
                                        <th>Estado</th>
                                        <th></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach($repair_orders as $or): ?>

                                        <tr>

                                            <td>

                                                <strong>
                                                    <?php echo $or['order_number'] ?? ('OR-'.$or['id']); ?>
                                                </strong>

                                            </td>

                                            <td>

                                                <?php echo date(
                                                    'd/m/Y',
                                                    strtotime($or['report_date'])
                                                ); ?>

                                            </td>

                                            <td>

                                                <?php

                                                $priority_class =
                                                    'priority-low';

                                                if($or['priority'] == 'MEDIA'){
                                                    $priority_class =
                                                        'priority-medium';
                                                }

                                                if($or['priority'] == 'ALTA'){
                                                    $priority_class =
                                                        'priority-high';
                                                }

                                                ?>

                                                <span
                                                    class="priority-badge <?php echo $priority_class; ?>"
                                                >
                                                    <?php echo $or['priority']; ?>
                                                </span>

                                            </td>

                                            <td>
                                                <?php echo $or['reported_by']; ?>
                                            </td>

                                            <td class="failure-column">

                                                <?php echo mb_strimwidth($or['failure_description'], 0, 80, '...');?>

                                            </td>

                                            <td>

                                                <span class="status-badge">
                                                    <?php echo $or['status']; ?>
                                                </span>

                                            </td>

                                            <td>

                                                <a href="../../modules/repair_orders/repair-order-detail.php?id=<?php echo $or['id']; ?>"class="btn btn-sm btn-outline-primary">
                                                    Detalle
                                                </a>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                    <div class="empty-state">

                        <i class="bi bi-tools"></i>

                        <h5>
                            No existen OR registradas
                        </h5>

                        <p>
                            Utilizá el botón "Nueva OR"
                            para cargar la primera.
                        </p>

                    </div>

                <?php endif; ?>

                </div>

                <div
                    class="tab-pane fade"
                    id="ot-tab">

                    <?php if(count($work_orders) > 0): ?>

                        <div class="table-responsive">

                            <table class="table">

                                <thead>

                                    <tr>

                                        <th>OT</th>
                                        <th>Fecha</th>
                                        <th>Técnico</th>
                                        <th>OR Asociada</th>
                                        <th></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach($work_orders as $wo): ?>

                                        <tr>

                                            <td>

                                                <?php echo $wo['work_order_number']; ?>

                                            </td>

                                            <td>

                                                <?php echo date(
                                                    'd/m/Y',
                                                    strtotime($wo['work_date'])
                                                ); ?>

                                            </td>

                                            <td>

                                                <?php echo $wo['mechanic_name']; ?>

                                            </td>

                                            <td>

                                                <?php echo $wo['order_number']; ?>

                                            </td>

                                            <td>

                                                <?php if(!empty($wo['file'])): ?>

                                                    <a
                                                        href="../../assets/uploads/repair_orders/<?php echo $wo['file']; ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary"
                                                    >
                                                        Ver PDF
                                                    </a>

                                                <?php endif; ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="empty-state">

                            <h5>
                                No existen OT registradas
                            </h5>

                        </div>

                    <?php endif; ?>

                </div>

                <div
                    class="tab-pane fade"
                    id="preventive-tab"
                >

                    <?php if(count($preventives) > 0): ?>

                        <div class="table-responsive">

                            <table class="table">

                                <thead>

                                    <tr>

                                        <th>Fecha</th>
                                        <th>Horómetro</th>
                                        <th>Observaciones</th>
                                        <th></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach($preventives as $pm): ?>

                                        <tr>

                                            <td>

                                                <?php echo date(
                                                    'd/m/Y',
                                                    strtotime($pm['maintenance_date'])
                                                ); ?>

                                            </td>

                                            <td>

                                                <?php echo number_format(
                                                    $pm['hourmeter'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ); ?>

                                                hs

                                            </td>

                                            <td>

                                                <?php echo mb_strimwidth(
                                                    $pm['observations'],
                                                    0,
                                                    80,
                                                    '...'
                                                ); ?>

                                            </td>

                                            <td>

                                                <?php if(!empty($pm['file'])): ?>

                                                    <a
                                                        href="../../assets/uploads/maintenances/<?php echo $pm['file']; ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-success"
                                                    >
                                                        Ver PDF
                                                    </a>

                                                <?php endif; ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="empty-state">

                            <h5>
                                No existen mantenimientos preventivos registrados
                            </h5>

                        </div>

                    <?php endif; ?>

                </div>

                <div
                    class="tab-pane fade"
                    id="downtime-tab"
                >

                <?php if(count($downtimes) > 0): ?>

                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Días</th>
                                    <th>Bonificación</th>
                                    <th>Motivo</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach($downtimes as $dt): ?>

                                <tr>

                                    <td>

                                        <?php echo date(
                                            'd/m/Y',
                                            strtotime($dt['start_date'])
                                        ); ?>

                                    </td>

                                    <td>

                                        <?php echo date(
                                            'd/m/Y',
                                            strtotime($dt['end_date'])
                                        ); ?>

                                    </td>

                                    <td>

                                        <?php echo $dt['days']; ?>

                                    </td>

                                    <td>

                                        $

                                        <?php echo number_format(

                                            $dt['manual_discount']
                                            ?: $dt['calculated_discount'],

                                            0,
                                            ',',
                                            '.'

                                        ); ?>

                                    </td>

                                    <td>

                                        <?php echo $dt['reason']; ?>

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <div class="alert alert-light">

                        Sin indisponibilidades registradas.

                    </div>

                <?php endif; ?>

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

<!-- ==========================
MODAL NUEVA OR
========================== -->

<div
    class="modal fade"
    id="repairOrderModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_repair_order.php"
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
                        Registrar Orden de Reparación
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
                                Fecha OR
                            </label>

                            <input
                                type="date"
                                name="report_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Reportado por
                            </label>

                            <input
                                type="text"
                                name="reported_by"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Prioridad
                        </label>

                        <select
                            name="priority"
                            class="form-select"
                            required
                        >
                            <option value="">
                                Seleccionar
                            </option>

                            <option value="BAJA">
                                Baja
                            </option>

                            <option value="MEDIA">
                                Media
                            </option>

                            <option value="ALTA">
                                Alta
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción de la falla
                        </label>

                        <textarea
                            name="failure_description"
                            rows="4"
                            class="form-control"
                            required
                        ></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OR
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                        >

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
                        Guardar OR
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="downtimeModal"
    tabindex="-1"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="../../controllers/downtimes/create_downtime.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Registrar Indisponibilidad
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        Valor mensual del equipo:

                        <strong>

                            $ <?php echo number_format(
                                $equipment['monthly_cost'],
                                0,
                                ',',
                                '.'
                            ); ?>

                        </strong>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha inicio
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha fin
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="form-control"
                            required
                        >

                    </div>

                    <div
                        id="manualWarning"
                        class="alert alert-warning d-none"
                    >

                        Atención:
                        se utilizará la bonificación manual
                        y no el cálculo automático.

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Bonificación Manual (opcional)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="manual_discount"
                            id="manual_discount"
                            class="form-control"
                        >

                        <small class="text-muted">

                            Dejar vacío para usar
                            el cálculo automático.

                        </small>

                    </div>

                    <div class="alert alert-success">

                        <div>

                            Días calculados:

                            <strong id="downtimeDays">
                                0
                            </strong>

                        </div>

                        <div>

                            Bonificación estimada:

                            <strong id="estimatedDiscount">
                                $ 0
                            </strong>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Motivo
                        </label>

                        <textarea
                            name="reason"
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
                        class="btn btn-danger"
                    >
                        Guardar Indisponibilidad
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

    const ctx =
        document.getElementById(
            'equipmentUsageChart'
        );

    new Chart(ctx, {

        type: 'line',

        data: {

            labels:
                <?php echo json_encode($months); ?>,

            datasets: [

                {

                    label: 'Horas Usadas',

                    data:
                        <?php echo json_encode($chart_hours); ?>,

                    borderColor: '#2563eb',

                    backgroundColor:
                        'rgba(37,99,235,0.08)',

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true,

                    pointRadius: 4,

                    pointHoverRadius: 6
                },

                {

                    label: 'Horas Contratadas',

                    data: [
                        240,240,240,240,240,240,
                        240,240,240,240,240,240
                    ],

                    borderColor: '#94a3b8',

                    borderDash: [6,6],

                    borderWidth: 2,

                    pointRadius: 0,

                    fill: false
                }

            ]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                mode: 'index',
                intersect: false
            },

            plugins: {

                legend: {

                    position: 'top',

                    align: 'end'
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    grid: {

                        color: '#eef2f7'
                    }
                },

                x: {

                    grid: {

                        display: false
                    }
                }
            }
        }
    });

</script>

<script>

const monthlyRate =
    <?php echo $equipment['monthly_cost']; ?>;

function daysInMonth(year, month){

    return new Date(
        year,
        month + 1,
        0
    ).getDate();

}

function calculateDowntime(){

    let start =
        document.getElementById('start_date').value;

    let end =
        document.getElementById('end_date').value;

    if(!start || !end){
        return;
    }

    const [y1,m1,dia1] = start.split('-').map(Number);
    const [y2,m2,dia2] = end.split('-').map(Number);

    let d1 = new Date(y1, m1 - 1, dia1);
    let d2 = new Date(y2, m2 - 1, dia2);

    if(d2 < d1){

    alert(
        'La fecha fin no puede ser menor a la fecha inicio'
    );

    document.getElementById(
        'downtimeDays'
    ).innerHTML = 0;

    document.getElementById(
        'estimatedDiscount'
    ).innerHTML = '$ 0';

    return;
}

    let diff =
        Math.floor(
            (d2 - d1) /
            (1000 * 60 * 60 * 24)
        ) + 1;

    let daysMonth =
        daysInMonth(
            d1.getFullYear(),
            d1.getMonth()
        );

    let dailyRate =
        monthlyRate / daysMonth;

        console.log(
    'Mes:',
    d1.getMonth() + 1
);

console.log(
    'Dias mes:',
    daysMonth
);

console.log(
    'Diff:',
    diff
);

console.log(
    'Rate:',
    dailyRate
);

    let amount =
        diff * dailyRate;

    document.getElementById(
    'downtimeDays'
).innerHTML = diff;

document.getElementById(
    'estimatedDiscount'
).innerHTML =
    '$ ' +
    amount.toLocaleString(
        'es-AR',
        {
            maximumFractionDigits: 0
        }
    );

}

document.addEventListener(

    'change',

    function(e){

        if(
            e.target.id == 'start_date' ||
            e.target.id == 'end_date'
        ){

            calculateDowntime();

        }

    }

);

document
.querySelector('#downtimeModal form')
.addEventListener(
    'submit',
    function(e){

        let start =
            document.getElementById(
                'start_date'
            ).value;

        let end =
            document.getElementById(
                'end_date'
            ).value;

        const [sy,sm,sd] = start.split('-').map(Number);
        const [ey,em,ed] = end.split('-').map(Number);

        const startDate = new Date(sy, sm - 1, sd);
        const endDate   = new Date(ey, em - 1, ed);

        if(endDate < startDate){

            e.preventDefault();

            alert(
                'La fecha fin no puede ser menor a la fecha inicio'
            );
        }

    }
);

</script>


<?php include '../../includes/footer.php'; ?>