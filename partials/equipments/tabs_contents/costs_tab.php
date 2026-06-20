<div class="tab-pane fade" id="costs-tab">

    <div class="d-flex justify-content-end mb-3">

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#costModal">
            Registrar costo
        </button>

    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Importe</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (count($costs) > 0): ?>

                    <?php foreach ($costs as $cost): ?>

                        <tr>
                            <td>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($cost['cost_date'])
                                ); ?>
                            </td>

                            <td>
                                <?php echo $cost['cost_type']; ?>
                            </td>

                            <td>
                                <?php echo $cost['description']; ?>
                            </td>

                            <td>
                                $<?php echo number_format(
                                    $cost['amount'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </td>

                            <td>
                                <?php if (!empty($cost['file'])): ?>

                                    <a
                                        href="../../assets/uploads/costs/<?php echo $cost['file']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        PDF
                                    </a>

                                <?php else: ?>

                                    <span class="text-muted">-</span>

                                <?php endif; ?>
                            </td>

                            <td>
                                <button
                                    class="btn btn-sm btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCostModal<?php echo $cost['id']; ?>">
                                    Editar
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCostModal<?php echo $cost['id']; ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <div
                            class="modal fade"
                            id="editCostModal<?php echo $cost['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/costs/update_cost.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $cost['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Editar costo
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
                                                        name="cost_date"
                                                        class="form-control"
                                                        value="<?php echo $cost['cost_date']; ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Tipo
                                                    </label>

                                                    <select
                                                        name="cost_type"
                                                        class="form-select"
                                                        required>

                                                        <option
                                                            value="HORAS_EXTRAS"
                                                            <?php echo ($cost['cost_type'] === 'HORAS_EXTRAS') ? 'selected' : ''; ?>>
                                                            Horas Extras
                                                        </option>

                                                        <option
                                                            value="TRASLADO"
                                                            <?php echo ($cost['cost_type'] === 'TRASLADO') ? 'selected' : ''; ?>>
                                                            Traslado
                                                        </option>

                                                        <option
                                                            value="RECUPERO"
                                                            <?php echo ($cost['cost_type'] === 'RECUPERO') ? 'selected' : ''; ?>>
                                                            Recupero
                                                        </option>

                                                        <option
                                                            value="OTROS"
                                                            <?php echo ($cost['cost_type'] === 'OTROS') ? 'selected' : ''; ?>>
                                                            Otros
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Descripción
                                                </label>

                                                <textarea
                                                    name="description"
                                                    class="form-control"
                                                    rows="3"><?php echo $cost['description']; ?></textarea>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Importe
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="amount"
                                                    class="form-control"
                                                    value="<?php echo $cost['amount']; ?>"
                                                    required>

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
                            id="deleteCostModal<?php echo $cost['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/costs/delete_cost.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $cost['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Eliminar costo
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

                <?php else: ?>

                    <tr>
                        <td
                            colspan="6"
                            class="text-center text-muted py-4">
                            No hay costos registrados.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>