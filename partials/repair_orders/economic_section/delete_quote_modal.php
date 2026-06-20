<div
    class="modal fade"
    id="deleteQuoteModal<?php echo $quote['id']; ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                method="POST"
                action="../../controllers/repair_quotes/delete_quote.php">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Eliminar presupuesto
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

                    <p>
                        Esta acción no borra el presupuesto físicamente, pero lo excluye de la orden de reparación.
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