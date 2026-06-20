<div
    class="modal fade"
    id="editQuoteModal<?php echo $quote['id']; ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                method="POST"
                action="../../controllers/repair_quotes/update_quote.php">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Editar presupuesto
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $quote['id']; ?>">

                    <input
                        type="hidden"
                        name="repair_order_id"
                        value="<?php echo $repair_order['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">
                            Número
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="quote_number"
                            value="<?php echo $quote['quote_number']; ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Fecha
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="quote_date"
                            value="<?php echo $quote['quote_date']; ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Monto
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="amount"
                            value="<?php echo $quote['amount']; ?>"
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
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>