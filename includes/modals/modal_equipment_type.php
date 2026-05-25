<div class="modal fade" id="equipmentTypeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tipos de equipos
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <form action="../../modules/equipments_types/store_equipment_type.php"
                      method="POST">
                    <div class="row align-items-end">
                        <div class="col-md-9">
                            <label class="form-label">
                                Nuevo tipo
                            </label>
                            <input type="text"
                                   name="equipment_type"
                                   class="form-control"
                                   placeholder="Ej: Autoelevador"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit"
                                    class="btn btn-primary w-100">
                                Agregar
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-4">
                <h6 class="mb-3">
                    Tipos registrados
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
                            <?php foreach($equipment_types as $type): ?>
                            <tr>
                                <td>
                                    <?php echo $type['id']; ?>
                                </td>
                                <td>
                                    <?php echo $type['type']; ?>
                                </td>
                                <td>

                                    <a href="../../modules/equipments_types/edit_equipment_type.php?id=<?php echo $type['id']; ?>"
                                        class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>

                                    <a href="../../modules/equipments_types/delete_equipment_type.php?id=<?php echo $type['id']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar tipo de equipo?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>