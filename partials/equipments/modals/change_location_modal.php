<div
    class="modal fade"
    id="changeLocationModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="../../controllers/equipments/change_location.php"
                method="POST">

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Cambiar Operación / Site
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong>Ubicación actual:</strong>

                        <br>

                        <?php echo $equipment['operation_name']; ?>

                        -

                        <?php echo $equipment['site_name']; ?>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Nueva Operación
                        </label>

                        <select
                            name="operation_id"
                            class="form-select"
                            required>

                            <option value="">
                                Seleccionar
                            </option>

                            <?php foreach ($operations as $operation): ?>

                                <option
                                    value="<?php echo $operation['id']; ?>">
                                    <?php echo $operation['name']; ?>
                                    -
                                    <?php echo $operation['site_name']; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
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
                        class="btn btn-primary">
                        Guardar Movimiento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>