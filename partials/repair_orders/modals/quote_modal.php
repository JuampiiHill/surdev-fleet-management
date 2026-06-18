<div
    class="modal fade"
    id="quoteModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_quote.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cargar Presupuesto
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

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
                            required>

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
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Presupuesto
                        </label>

                        <input
                            type="file"
                            name="file_1"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF Adicional
                        </label>

                        <input
                            type="file"
                            name="file_2"
                            class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Guardar Presupuesto
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>