<div
    class="modal fade"
    id="repairOrderModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/create_repair_order.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Registrar Orden de Reparación
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong>Equipo:</strong>

                        <?php echo $equipment['internal_number']; ?>

                        -

                        <?php echo $equipment['brand']; ?>

                        <?php echo $equipment['model']; ?>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Fecha OR
                            </label>

                            <input
                                type="date"
                                name="report_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Reportado por
                            </label>

                            <input
                                type="text"
                                name="reported_by"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Prioridad
                        </label>

                        <select
                            name="priority"
                            class="form-select"
                            required>
                            <option value="">
                                Seleccionar
                            </option>

                            <option value="BAJA">
                                Baja
                            </option>

                            <option value="MEDIA">
                                Media
                            </option>

                            <option value="ALTA">
                                Alta
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción de la falla
                        </label>

                        <textarea
                            name="failure_description"
                            rows="4"
                            class="form-control"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OR
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control">

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
                        class="btn btn-success">
                        Guardar OR
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>