<div
    class="tab-pane fade"
    id="downtime-tab">

    <?php if (count($downtimes) > 0): ?>

        <div class="table-responsive">

            <table class="table">

                <thead>
                    <tr>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Días</th>
                        <th>Bonificación</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($downtimes as $dt): ?>

                        <?php
                            $discount =
                                $dt['manual_discount']
                                    ?: $dt['calculated_discount'];
                        ?>

                        <tr>
                            <td>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($dt['start_date'])
                                ); ?>
                            </td>

                            <td>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($dt['end_date'])
                                ); ?>
                            </td>

                            <td>
                                <?php echo $dt['days']; ?>
                            </td>

                            <td>
                                $<?php echo number_format(
                                    $discount,
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </td>

                            <td>
                                <?php echo $dt['reason']; ?>
                            </td>

                            <td>
                                <button
                                    class="btn btn-sm btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editDowntimeModal<?php echo $dt['id']; ?>">
                                    Editar
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteDowntimeModal<?php echo $dt['id']; ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <div
                            class="modal fade"
                            id="editDowntimeModal<?php echo $dt['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/downtimes/update_downtime.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $dt['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Editar indisponibilidad
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Desde
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="start_date"
                                                        class="form-control"
                                                        value="<?php echo $dt['start_date']; ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Hasta
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="end_date"
                                                        class="form-control"
                                                        value="<?php echo $dt['end_date']; ?>"
                                                        required>

                                                </div>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Bonificación manual
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="manual_discount"
                                                    class="form-control"
                                                    value="<?php echo $dt['manual_discount']; ?>">

                                                <small class="text-muted">
                                                    Si se deja vacío, el sistema recalcula la bonificación.
                                                </small>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Motivo
                                                </label>

                                                <textarea
                                                    name="reason"
                                                    class="form-control"
                                                    rows="3"
                                                    required><?php echo $dt['reason']; ?></textarea>

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
                                                Guardar cambios
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div
                            class="modal fade"
                            id="deleteDowntimeModal<?php echo $dt['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/downtimes/delete_downtime.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $dt['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Eliminar indisponibilidad
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <p>
                                                Esta acción no borra el registro físicamente, pero lo excluye de reportes y costos.
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

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="alert alert-light">
            Sin indisponibilidades registradas.
        </div>

    <?php endif; ?>

</div>