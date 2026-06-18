<div
    class="modal fade"
    id="downtimeModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="../../controllers/downtimes/create_downtime.php"
                method="POST">

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Registrar Indisponibilidad
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        Valor mensual del equipo:

                        <strong>

                            $ <?php echo number_format(
                                    $equipment['monthly_cost'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                        </strong>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha inicio
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Fecha fin
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="form-control"
                            required>

                    </div>

                    <div
                        id="manualWarning"
                        class="alert alert-warning d-none">

                        Atención:
                        se utilizará la bonificación manual
                        y no el cálculo automático.

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Bonificación Manual (opcional)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="manual_discount"
                            id="manual_discount"
                            class="form-control">

                        <small class="text-muted">

                            Dejar vacío para usar
                            el cálculo automático.

                        </small>

                    </div>

                    <div class="alert alert-success">

                        <div>

                            Días calculados:

                            <strong id="downtimeDays">
                                0
                            </strong>

                        </div>

                        <div>

                            Bonificación estimada:

                            <strong id="estimatedDiscount">
                                $ 0
                            </strong>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Motivo
                        </label>

                        <textarea
                            name="reason"
                            rows="3"
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
                        class="btn btn-danger">
                        Guardar Indisponibilidad
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>