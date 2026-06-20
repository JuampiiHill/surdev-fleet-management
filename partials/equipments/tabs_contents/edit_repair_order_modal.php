<div class="modal fade"
    id="editRepairOrderModal<?php echo $or['id']; ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="../../controllers/repair_orders/update_repair_order.php"
                method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $or['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Editar OR
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
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="report_date"
                            class="form-control"
                            value="<?php echo $or['report_date']; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Reportado por
                        </label>

                        <input
                            type="text"
                            name="reported_by"
                            class="form-control"
                            value="<?php echo $or['reported_by']; ?>">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Prioridad
                        </label>

                        <select
                            name="priority"
                            class="form-select">

                            <option value="BAJA"
                                <?php if ($or['priority'] == 'BAJA') echo 'selected'; ?>>
                                BAJA
                            </option>

                            <option value="MEDIA"
                                <?php if ($or['priority'] == 'MEDIA') echo 'selected'; ?>>
                                MEDIA
                            </option>

                            <option value="ALTA"
                                <?php if ($or['priority'] == 'ALTA') echo 'selected'; ?>>
                                ALTA
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="ABIERTA"
                                <?php if ($or['status'] == 'ABIERTA') echo 'selected'; ?>>
                                ABIERTA
                            </option>

                            <option value="EN PROCESO"
                                <?php if ($or['status'] == 'EN PROCESO') echo 'selected'; ?>>
                                EN PROCESO
                            </option>

                            <option value="CERRADA"
                                <?php if ($or['status'] == 'CERRADA') echo 'selected'; ?>>
                                CERRADA
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

    <label class="form-label">
        Descripción
    </label>

    <textarea
        name="failure_description"
        class="form-control"
        rows="4"><?php echo $or['failure_description']; ?></textarea>

</div>

<div class="mb-3">

    <label class="form-label">
        Comentario de cierre
    </label>

    <textarea
        name="resolution_summary"
        class="form-control"
        rows="3"><?php echo $or['resolution_summary'] ?? ''; ?></textarea>

    <small class="text-muted">
        Obligatorio si la OR se cierra sin OT asociada.
    </small>

</div>

                    <div class="mb-3">

                        <label class="form-label">
                            Comentario de cierre / resolución
                        </label>

                        <textarea
                            name="resolution_summary"
                            class="form-control"
                            rows="3"><?php echo $or['resolution_summary'] ?? ''; ?></textarea>

                        <small class="text-muted">
                            Obligatorio si la OR se cierra sin OT asociada.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

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