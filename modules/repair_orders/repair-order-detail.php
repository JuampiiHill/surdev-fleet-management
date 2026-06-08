<?php

session_start();

require_once '../../config/database.php';

if(!isset($_GET['id'])){

    header('Location: ../dashboard/dashboard.php');
    exit;
}

$repair_order_id = $_GET['id'];

$sql = "

    SELECT

        ro.*,

        e.internal_number,
        e.brand,
        e.model

    FROM repair_orders ro

    INNER JOIN equipments e
        ON ro.equipment_id = e.id

    WHERE ro.id = :id

";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $repair_order_id
]);

$repair_order = $stmt->fetch();

if(!$repair_order){

    header('Location: ../dashboard/dashboard.php');
    exit;
}

$sql_work_orders = "

    SELECT *
    FROM repair_work_orders
    WHERE repair_order_id = :repair_order_id
    ORDER BY work_date ASC, id ASC

";

$stmt_work_orders =
    $conexion->prepare($sql_work_orders);

$stmt_work_orders->execute([
    ':repair_order_id' => $repair_order_id
]);

$work_orders =
    $stmt_work_orders->fetchAll();

    $sql_quotes = "

    SELECT *
    FROM repair_quotes
    WHERE repair_order_id = :repair_order_id
    ORDER BY quote_date DESC

";

$stmt_quotes =
    $conexion->prepare($sql_quotes);

$stmt_quotes->execute([
    ':repair_order_id' => $repair_order_id
]);

$quotes =
    $stmt_quotes->fetchAll();
$sql_invoices = "

    SELECT *
    FROM repair_invoices
    WHERE repair_order_id = :repair_order_id
    ORDER BY invoice_date DESC

";

$stmt_invoices =
    $conexion->prepare($sql_invoices);

$stmt_invoices->execute([
    ':repair_order_id' => $repair_order_id
]);

$invoices =
    $stmt_invoices->fetchAll();

include '../../includes/header.php';
include '../../includes/sidebar.php';

?>

<div class="main-content p-4">

    <a
        href="../../views/equipments/equipment_detail.php?id=<?php echo $repair_order['equipment_id']; ?>"
        class="btn btn-outline-secondary mb-4"
    >
        ← Volver al Equipo
    </a>

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h2 class="mb-1">
                        <?php echo $repair_order['order_number']; ?>
                    </h2>

                    <p class="text-muted mb-0">

                        Equipo:

                        <strong>

                            <?php echo $repair_order['internal_number']; ?>

                        </strong>

                        -

                        <?php echo $repair_order['brand']; ?>

                        <?php echo $repair_order['model']; ?>

                    </p>

                </div>

                <div>

                    <span class="badge bg-primary">

                        <?php echo $repair_order['status']; ?>

                    </span>

                </div>

            </div>

            <hr>

            <h5>
                Descripción de Falla
            </h5>

            <p>
                <?php echo nl2br($repair_order['failure_description']); ?>
            </p>

            <?php if(!empty($repair_order['file'])): ?>

                    <a href="../../assets/uploads/repair_orders/<?php echo $repair_order['file']; ?> "target="_blank" class="btn btn-outline-primary">
                        Ver OR Original
                    </a>

                <?php endif; ?>

        </div>

    </div>

    <div class="d-flex gap-2 mb-4">

        <button
            class="btn btn-success"
            data-bs-toggle="modal"
            data-bs-target="#workOrderModal"
        >
            Nueva OT
        </button>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#quoteModal"
        >
            Presupuesto
        </button>

        <button
            class="btn btn-warning"
            data-bs-toggle="modal"
            data-bs-target="#invoiceModal"
        >
            Factura
        </button>

        <?php if($repair_order['status'] != 'CERRADA'): ?>

            <button
                class="btn btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#closeRepairOrderModal"
            >
                Cerrar OR
            </button>

        <?php endif; ?>

    </div>

<!-- MODAL NUEVA OT -->

<div
    class="modal fade"
    id="workOrderModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_work_order.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nueva OT
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="work_date"
                            class="form-control"
                            value="<?php echo date('Y-m-d'); ?>"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Número OT
                        </label>

                        <input type="text" name="work_order_number" class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Técnico
                        </label>

                        <input
                            type="text"
                            name="mechanic_name"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción de Trabajo
                        </label>

                        <textarea
                            name="work_description"
                            class="form-control"
                            rows="5"
                            required
                        ></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OT
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
                        type="submit"
                        class="btn btn-success"
                    >
                        Guardar OT
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="row">

    <!-- HISTORIAL OT -->

    <div class="col-md-6">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <h4 class="mb-0">
                    Historial de OT
                </h4>

            </div>

            <div class="card-body">

                <?php if(count($work_orders) > 0): ?>

                    <?php foreach($work_orders as $wo): ?>

                        <div class="border rounded p-3 mb-3">

                            <div class="d-flex justify-content-between">

                                <strong>
                                    <?php echo date(
                                        'd/m/Y',
                                        strtotime($wo['work_date'])
                                    ); ?>
                                </strong>

                                <span>
                                    <?php echo $wo['mechanic_name']; ?>
                                </span>

                            </div>

                            <hr>

                            <p>
                                <?php echo nl2br($wo['work_description']); ?>
                            </p>

                            <?php if(!empty($wo['work_order_number'])): ?>

                                <small class="text-muted">
                                    OT Nº:
                                    <?php echo $wo['work_order_number']; ?>
                                </small>

                            <?php endif; ?>

                            <?php if(!empty($wo['file'])): ?>

                                <div class="mt-2">

                                    <a
                                        href="../../assets/uploads/repair_orders/<?php echo $wo['file']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Ver OT
                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="alert alert-info">

                        No existen OT cargadas para esta OR.

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- INFORMACION ECONOMICA -->

    <div class="col-md-6">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <h4 class="mb-0">
                    Información Económica
                </h4>

            </div>

            <div class="card-body">

                <h5>Presupuestos</h5>

                <?php if(count($quotes) > 0): ?>

                    <?php foreach($quotes as $quote): ?>

                        <div class="border rounded p-2 mb-2">

                            <strong>
                                Presupuesto Nº <?php echo $quote['quote_number']; ?>
                            </strong>

                            <br>

                            Fecha:
                            <?php echo date(
                                'd/m/Y',
                                strtotime($quote['quote_date'])
                            ); ?>

                            <br>

                            Monto:
                            $<?php echo number_format(
                                $quote['amount'],
                                0,
                                ',',
                                '.'
                            ); ?>

                            <div class="mt-2">

                                <?php if(!empty($quote['file_1'])): ?>

                                    <a
                                        href="../../assets/uploads/repair_quotes/<?php echo $quote['file_1']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        PDF 1
                                    </a>

                                <?php endif; ?>

                                <?php if(!empty($quote['file_2'])): ?>

                                    <a
                                        href="../../assets/uploads/repair_quotes/<?php echo $quote['file_2']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        PDF 2
                                    </a>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="alert alert-light">
                        Sin presupuestos cargados.
                    </div>

                <?php endif; ?>

                <hr>

                <h5>Facturas</h5>

                <?php if(count($invoices) > 0): ?>

                    <?php foreach($invoices as $invoice): ?>

                        <div class="border rounded p-2 mb-2">

                            <strong>
                                Factura Nº <?php echo $invoice['invoice_number']; ?>
                            </strong>

                            <br>

                            Fecha:
                            <?php echo date(
                                'd/m/Y',
                                strtotime($invoice['invoice_date'])
                            ); ?>

                            <br>

                            Monto:
                            $<?php echo number_format(
                                $invoice['amount'],
                                0,
                                ',',
                                '.'
                            ); ?>

                            <?php if(!empty($invoice['file'])): ?>

                                <div class="mt-2">

                                    <a
                                        href="../../assets/uploads/repair_invoices/<?php echo $invoice['file']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-warning"
                                    >
                                        Ver Factura
                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="alert alert-light">
                        Sin facturas cargadas.
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<!-- MODAL CERRAR OR -->

<div
    class="modal fade"
    id="closeRepairOrderModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/close_repair_order.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cerrar Orden de Reparación
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Resumen de reparación
                        </label>

                        <textarea
                            name="resolution_summary"
                            rows="5"
                            class="form-control"
                            required
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
                        Cerrar OR
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="quoteModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_quote.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cargar Presupuesto
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Número Presupuesto
                        </label>

                        <input
                            type="text"
                            name="quote_number"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="quote_date"
                            class="form-control"
                            value="<?php echo date('Y-m-d'); ?>"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Monto
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Presupuesto
                        </label>

                        <input
                            type="file"
                            name="file_1"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Adicional
                        </label>

                        <input
                            type="file"
                            name="file_2"
                            class="form-control"
                        >

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Guardar Presupuesto
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="invoiceModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_invoice.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>"
                >

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cargar Factura
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Presupuesto Asociado
                        </label>

                        <select
                            name="quote_id"
                            class="form-select"
                        >

                            <option value="">
                                Sin presupuesto
                            </option>

                            <?php foreach($quotes as $quote): ?>

                                <option value="<?php echo $quote['id']; ?>">

                                    <?php echo $quote['quote_number']; ?>

                                    -

                                    $

                                    <?php echo number_format(
                                        $quote['amount'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Número Factura
                        </label>

                        <input
                            type="text"
                            name="invoice_number"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha Factura
                        </label>

                        <input
                            type="date"
                            name="invoice_date"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Monto Facturado
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Factura
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
                        type="submit"
                        class="btn btn-warning"
                    >
                        Guardar Factura
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>