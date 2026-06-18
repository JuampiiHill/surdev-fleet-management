<div
    class="modal fade"
    id="workOrderModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_work_order.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="repair_order_id"
                    value="<?php echo $repair_order['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nueva OT
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

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
                            required>

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
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción de Trabajo
                        </label>

                        <textarea
                            name="work_description"
                            class="form-control"
                            rows="5"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OT
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
                        class="btn btn-success">
                        Guardar OT
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>