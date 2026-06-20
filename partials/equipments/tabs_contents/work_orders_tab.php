<div
    class="tab-pane fade"
    id="ot-tab">

    <?php if (count($work_orders) > 0): ?>

        <div class="table-responsive">

            <table class="table">

                <thead>
                    <tr>
                        <th>OT</th>
                        <th>Fecha</th>
                        <th>Técnico</th>
                        <th>Trabajo realizado</th>
                        <th>OR Asociada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($work_orders as $wo): ?>

                        <tr>
                            <td>
                                <?php echo $wo['work_order_number']; ?>
                            </td>

                            <td>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($wo['work_date'])
                                ); ?>
                            </td>

                            <td>
                                <?php echo $wo['mechanic_name']; ?>
                            </td>

                            <td>
                                <?php echo mb_strimwidth($wo['work_description'] ?? '', 0, 80, '...'); ?>
                            </td>

                            <td>
                                <?php echo $wo['order_number']; ?>
                            </td>

                            <td>
                                <?php if (!empty($wo['file'])): ?>

                                    <a
                                        href="../../assets/uploads/repair_orders/<?php echo $wo['file']; ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        Ver PDF
                                    </a>

                                <?php endif; ?>

                                <button
                                    class="btn btn-sm btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editWorkOrderModal<?php echo $wo['id']; ?>">
                                    Editar
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteWorkOrderModal<?php echo $wo['id']; ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <div
                            class="modal fade"
                            id="editWorkOrderModal<?php echo $wo['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/work_orders/update_work_order.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $wo['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Editar OT
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Número OT
                                                </label>

                                                <input
                                                    type="text"
                                                    name="work_order_number"
                                                    class="form-control"
                                                    value="<?php echo $wo['work_order_number']; ?>"
                                                    required>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Fecha
                                                </label>

                                                <input
                                                    type="date"
                                                    name="work_date"
                                                    class="form-control"
                                                    value="<?php echo $wo['work_date']; ?>"
                                                    required>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Técnico
                                                </label>

                                                <input
                                                    type="text"
                                                    name="mechanic_name"
                                                    class="form-control"
                                                    value="<?php echo $wo['mechanic_name']; ?>">

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Trabajo realizado
                                                </label>

                                                <textarea
                                                    name="work_description"
                                                    class="form-control"
                                                    rows="4"><?php echo $wo['work_description']; ?></textarea>

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
                            id="deleteWorkOrderModal<?php echo $wo['id']; ?>"
                            tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <form
                                        action="../../controllers/work_orders/delete_work_order.php"
                                        method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php echo $wo['id']; ?>">

                                        <input
                                            type="hidden"
                                            name="equipment_id"
                                            value="<?php echo $equipment['id']; ?>">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Eliminar OT
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body">

                                            <p>
                                                La OT será excluida del historial del equipo.
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
                No existen OT registradas
            </h5>
        </div>

    <?php endif; ?>

</div>