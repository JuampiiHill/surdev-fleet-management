<div
    class="modal fade"
    id="invoiceModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_invoice.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cargar Factura
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Presupuesto Asociado
                        </label>

                        <select
                            name="quote_id"
                            class="form-select">

                            <option value="">
                                Sin presupuesto
                            </option>

                            <?php foreach ($quotes as $quote): ?>

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
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha Factura
                        </label>

                        <input
                            type="date"
                            name="invoice_date"
                            class="form-control"
                            required>

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
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Factura
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-warning">
                        Guardar Factura
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>