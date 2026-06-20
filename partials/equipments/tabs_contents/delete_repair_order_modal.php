<div class="modal fade"
    id="deleteRepairOrderModal<?php echo $or['id']; ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/delete_repair_order.php"
                method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $or['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Eliminar OR
                    </h5>

                </div>

                <div class="modal-body">

                    <p>
                        La OR será excluida de los listados y reportes.
                    </p>

                    <div class="mb-3">

                        <label class="form-label">
                            Motivo
                        </label>

                        <textarea
                            name="delete_reason"
                            class="form-control"
                            required></textarea>

                    </div>

                </div>

                <div class="modal-footer">

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