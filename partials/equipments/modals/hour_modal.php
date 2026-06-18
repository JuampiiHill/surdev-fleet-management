<div class="modal fade" id="hoursModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title">
                        Registrar Horas
                    </h5>

                    <small class="text-muted">
                        <?php echo $equipment['internal_number']; ?>
                        -
                        <?php echo $equipment['brand']; ?>
                        <?php echo $equipment['model']; ?>
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action="../../modules/hours/register-hours.php?equipment_id=<?php echo $equipment['id']; ?>"
                method="POST">

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong>
                            Horómetro actual:
                        </strong>

                        <?php echo number_format(
                            $equipment['current_hourmeter'],
                            2,
                            ',',
                            '.'
                        ); ?>

                        hs

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Fecha
                            </label>

                            <input
                                type="date"
                                name="work_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Horas trabajadas
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                name="hours"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
                            class="form-control"
                            rows="4"></textarea>

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
                        Guardar Horas
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>