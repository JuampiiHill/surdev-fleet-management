<div class="modal fade" id="createSiteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Nuevo Site
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../../modules/sites/store_site.php" method="POST">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Nombre site
                        </label>

                        <input type="text"
                               name="site"
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
                    Sites registrados
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
                            <?php foreach($sites as $site): ?>
                            <tr>
                                <td>
                                    <?php echo $site['id']; ?>
                                </td>
                                <td>
                                    <?php echo $site['name']; ?>
                                </td>
                                <td>

                                    <a href="../../modules/sites/edit_site.php?id=<?php echo $site['id']; ?>"
                                        class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>

                                    <!--<a href="../../modules/sites/delete_site.php?id=<?php echo $site['id']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar tipo de equipo?')">
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