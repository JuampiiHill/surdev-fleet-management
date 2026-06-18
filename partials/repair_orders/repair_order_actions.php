<div class="d-flex gap-2 mb-4">

    <button
        class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#workOrderModal">
        Nueva OT
    </button>

    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#quoteModal">
        Presupuesto
    </button>

    <button
        class="btn btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#invoiceModal">
        Factura
    </button>

    <?php if ($repair_order['status'] != 'CERRADA'): ?>

        <button
            class="btn btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#closeRepairOrderModal">
            Cerrar OR
        </button>

    <?php endif; ?>

</div>