<div class="modal fade" id="createOperationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Nueva Operacion
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../../modules/store_operation.php" method="POST">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Nombre operacion
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Site
                        </label>

                        <select name="site" class="form-select">

                            <option value="">
                                Seleccionar site
                            </option>

                            <?php foreach($sites as $site): ?>

                                <option value="<?php echo $site['id']; ?>">
                                    <?php echo $site['name']; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Negocio
                        </label>

                        <select name="business" class="form-select">

                            <option value="">
                                Seleccionar negocio
                            </option>

                            <?php foreach($business as $b): ?>

                                <option value="<?php echo $b['id']; ?>">
                                    <?php echo $b['name']; ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>