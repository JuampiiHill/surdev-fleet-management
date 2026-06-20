<div class="col-md-6">

    <div class="card shadow-sm h-100">

        <div class="card-header">

            <h4 class="mb-0">
                Información Económica
            </h4>

        </div>

        <div class="card-body">

            <h5>Presupuestos</h5>

            <?php if (count($quotes) > 0): ?>
                
                <?php foreach ($quotes as $quote): ?>

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

                        <div class="mt-2 mb-2">

                            <button
                                class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editQuoteModal<?php echo $quote['id']; ?>">
                                Editar
                            </button>

                            <button
                                class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteQuoteModal<?php echo $quote['id']; ?>">
                                Eliminar
                            </button>

                        </div>

                        <div class="mt-2">

                            <?php if (!empty($quote['file_1'])): ?>

                                <a
                                    href="../../assets/uploads/repair_quotes/<?php echo $quote['file_1']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    PDF 1
                                </a>

                            <?php endif; ?>

                            <?php if (!empty($quote['file_2'])): ?>

                                <a
                                    href="../../assets/uploads/repair_quotes/<?php echo $quote['file_2']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    PDF 2
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                   <?php include 'economic_section/edit_quote_modal.php'; ?>
    <?php include 'economic_section/delete_quote_modal.php'; ?>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="alert alert-light">
                    Sin presupuestos cargados.
                </div>

            <?php endif; ?>

            <hr>

            <h5>Facturas</h5>

            <?php if (count($invoices) > 0): ?>

                <?php foreach ($invoices as $invoice): ?>

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

                        <div class="mt-2 d-flex gap-2 flex-wrap">

                            <?php if (!empty($invoice['file'])): ?>

                                <a
                                    href="../../assets/uploads/repair_invoices/<?php echo $invoice['file']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-warning">
                                    Ver Factura
                                </a>

                            <?php endif; ?>

                            <button
                                class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editInvoiceModal<?php echo $invoice['id']; ?>">
                                Editar
                            </button>

                            <button
                                class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteInvoiceModal<?php echo $invoice['id']; ?>">
                                Eliminar
                            </button>

                        </div>

                    </div>

                    <div
                        class="modal fade"
                        id="editInvoiceModal<?php echo $invoice['id']; ?>"
                        tabindex="-1">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <form
                                    action="../../controllers/repair_invoices/update_invoice.php"
                                    method="POST">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $invoice['id']; ?>">

                                    <input
                                        type="hidden"
                                        name="repair_order_id"
                                        value="<?php echo $repair_order['id']; ?>">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Editar factura
                                        </h5>

                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">

                                            <label class="form-label">
                                                Número de factura
                                            </label>

                                            <input
                                                type="text"
                                                name="invoice_number"
                                                class="form-control"
                                                value="<?php echo $invoice['invoice_number']; ?>"
                                                required>

                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label">
                                                Fecha
                                            </label>

                                            <input
                                                type="date"
                                                name="invoice_date"
                                                class="form-control"
                                                value="<?php echo $invoice['invoice_date']; ?>"
                                                required>

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
                                                value="<?php echo $invoice['amount']; ?>"
                                                required>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="btn btn-primary">
                                            Guardar cambios
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div
                        class="modal fade"
                        id="deleteInvoiceModal<?php echo $invoice['id']; ?>"
                        tabindex="-1">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <form
                                    action="../../controllers/repair_invoices/delete_invoice.php"
                                    method="POST">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $invoice['id']; ?>">

                                    <input
                                        type="hidden"
                                        name="repair_order_id"
                                        value="<?php echo $repair_order['id']; ?>">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Eliminar factura
                                        </h5>

                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <p>
                                            Esta acción no borra la factura físicamente, pero la excluye de la OR y de los reportes de facturación.
                                        </p>

                                        <div class="mb-3">

                                            <label class="form-label">
                                                Motivo de eliminación
                                            </label>

                                            <textarea
                                                name="delete_reason"
                                                class="form-control"
                                                rows="3"
                                                required></textarea>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="btn btn-danger">
                                            Eliminar
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

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