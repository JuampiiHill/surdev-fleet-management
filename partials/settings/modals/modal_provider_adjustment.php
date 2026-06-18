<div
    class="modal fade"
    id="providerAdjustmentModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/provider_rate_adjustments/store_adjustment.php"
                method="POST">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title">
                            Nuevo ajuste tarifario
                        </h5>

                        <p class="text-muted mb-0">
                            Aplicá un porcentaje de aumento a todos los equipos activos de un proveedor.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Proveedor
                        </label>

                        <select
                            name="provider_id"
                            class="form-select"
                            required>

                            <option value="">
                                Seleccionar proveedor
                            </option>

                            <?php foreach ($providers as $provider): ?>

                                <option value="<?php echo $provider['id']; ?>">
                                    <?php echo $provider['name']; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Desde período
                            </label>

                            <input
                                type="month"
                                name="start_period"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Hasta período
                            </label>

                            <input
                                type="month"
                                name="end_period"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Porcentaje de aumento
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                step="0.0001"
                                name="percentage"
                                class="form-control"
                                placeholder="Ej: 3.35"
                                required>

                            <span class="input-group-text">
                                %
                            </span>

                        </div>

                        <small class="text-muted">
                            Se aplica sobre el último valor mensual vigente del equipo.
                        </small>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Ej: Ajuste polinómica junio 2026"></textarea>

                    </div>

                    <div class="alert alert-warning mb-0">

                        Este proceso creará o actualizará las tarifas mensuales del período seleccionado
                        para todos los equipos activos del proveedor.

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
                        Aplicar ajuste
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>