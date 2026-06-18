
<div
    class="modal fade"
    id="preventiveModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/maintenances/create_maintenance.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Registrar Mantenimiento Preventivo
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
                                Fecha mantenimiento
                            </label>

                            <input
                                type="date"
                                name="maintenance_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Horómetro al realizar mantenimiento
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="hourmeter"
                                class="form-control"
                                value="<?php echo $equipment['current_hourmeter']; ?>"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Adjuntar OT / Informe / PDF
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
                            rows="4"
                            class="form-control"></textarea>

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
                        Guardar Preventivo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>