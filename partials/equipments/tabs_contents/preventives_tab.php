<div
    class="tab-pane fade"
    id="preventive-tab">

    <?php if (count($preventives) > 0): ?>

        <div class="table-responsive">

            <table class="table">

                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Horómetro</th>
                        <th>Observaciones</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($preventives as $pm): ?>

                        <tr>
                            <td>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($pm['maintenance_date'])
                                ); ?>
                            </td>

                            <td>
                                <?php echo number_format(
                                    $pm['hourmeter'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                                hs
                            </td>

                            <td>
                                <?php echo mb_strimwidth(
                                    $pm['observations'] ?? '',
                                    0,
                                    80,
                                    '...'
                                ); ?>
                            </td>

                            <td>
                                <?php if (!empty($pm['file'])): ?>

                                    <a
                                        href="../../assets/uploads/maintenances/<?php echo $pm['file']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-success">
                                        Ver PDF
                                    </a>

                                <?php else: ?>

                                    <span class="text-muted">-</span>

                                <?php endif; ?>
                            </td>

                            <td>
                                <button
                                    class="btn btn-sm btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPreventiveModal<?php echo $pm['id']; ?>">
                                    Editar
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deletePreventiveModal<?php echo $pm['id']; ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <div
                            class="modal fade"
                            id="editPreventiveModal<?php echo $pm['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/preventives/update_preventive.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $pm['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Editar preventivo
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
                                                        Fecha
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="maintenance_date"
                                                        class="form-control"
                                                        value="<?php echo $pm['maintenance_date']; ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Horómetro
                                                    </label>

                                                    <input
                                                        type="number"
                                                        step="0.01"
                                                        name="hourmeter"
                                                        class="form-control"
                                                        value="<?php echo $pm['hourmeter']; ?>"
                                                        required>

                                                </div>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Observaciones
                                                </label>

                                                <textarea
                                                    name="observations"
                                                    class="form-control"
                                                    rows="4"><?php echo $pm['observations'] ?? ''; ?></textarea>

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
                            id="deletePreventiveModal<?php echo $pm['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/preventives/delete_preventive.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $pm['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Eliminar preventivo
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <p>
                                                Esta acción no borra el registro físicamente, pero lo excluye del historial y del cálculo del próximo mantenimiento.
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

        <div class="empty-state">

            <h5>
                No existen mantenimientos preventivos registrados
            </h5>

        </div>

    <?php endif; ?>

</div>