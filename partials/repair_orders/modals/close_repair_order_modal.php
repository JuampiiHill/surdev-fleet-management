<div
    class="modal fade"
    id="closeRepairOrderModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/close_repair_order.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cerrar Orden de Reparación
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

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
                        Cerrar OR
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>