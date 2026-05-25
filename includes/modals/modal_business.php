<div class="modal fade" id="createBusinessModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Nuevo Negocio
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../../modules/business/store_business.php" method="POST">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Nombre del negocio
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               required>
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

            <hr class="my-4">
                <h6 class="mb-3">
                    Negocios registrados
                </h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th width="180">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($business as $b): ?>
                            <tr>
                                <td>
                                    <?php echo $b['id']; ?>
                                </td>
                                <td>
                                    <?php echo $b['name']; ?>
                                </td>
                                <td>

                                    <a href="../../modules/business/edit_business.php?id=<?php echo $b['id']; ?>"
                                        class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>

                                    <!--<a href="../../modules/operations/delete_operation.php?id=<?php echo $b['id']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar operacion')">
                                        Eliminar
                                    </a> -->
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

        </div>
    </div>
</div>