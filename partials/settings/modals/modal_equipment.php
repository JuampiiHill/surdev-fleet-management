?>
<div class="modal fade" id="createEquipmentModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content login-modal">

            <div class="modal-header border-0">

                <div>
                    <h4 class="fw-bold mb-1">
                        Nuevo equipo
                    </h4>

                    <p class="text-muted mb-0">
                        Registro de un nuevo equipo
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action="../../controllers/equipments/create_equipment.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="modal-body">

                    <!-- FILA 1 -->

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <label class="form-label login-label">
                                Interno
                            </label>

                            <input
                                type="text"
                                name="internal_number"
                                class="form-control login-input"
                                required
                            >

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label login-label">
                                Marca
                            </label>

                            <input
                                type="text"
                                name="brand"
                                class="form-control login-input"
                            >

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label login-label">
                                Modelo
                            </label>

                            <input
                                type="text"
                                name="model"
                                class="form-control login-input"
                                required
                            >

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label login-label">
                                Año
                            </label>

                            <input
                                type="number"
                                name="year"
                                class="form-control login-input"
                            >

                        </div>

                    </div>

                    <!-- FILA 2 -->

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Nº Serie
                            </label>

                            <input
                                type="text"
                                name="serial_number"
                                class="form-control login-input"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Tipo de equipo
                            </label>

                            <select
                                name="equipment_type_id"
                                class="form-select login-input"
                                required
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                <?php foreach($equipment_types as $type): ?>

                                    <option value="<?php echo $type['id']; ?>">
                                        <?php echo $type['type']; ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Operación
                            </label>

                            <select
                                name="operation_id"
                                class="form-select login-input"
                                required
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                <?php foreach($operations as $op): ?>

                                    <option value="<?php echo $op['id']; ?>">
                                        <?php echo $op['name']; ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                    <!-- FILA 3 -->

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Proveedor
                            </label>

                            <select
                                name="provider_id"
                                class="form-select login-input"
                                required
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                <?php foreach($providers as $provider): ?>

                                    <option value="<?php echo $provider['id']; ?>">
                                        <?php echo $provider['name']; ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Horómetro inicial
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="initial_hourmeter"
                                class="form-control login-input"
                                value="0"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Intervalo mantenimiento (hs)
                            </label>

                            <input
                                type="number"
                                name="maintenance_interval_hours"
                                class="form-control login-input"
                                value="250"
                            >

                        </div>

                    </div>

                    <!-- FILA 4 -->

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Hs mensuales contratadas
                            </label>

                            <input
                                type="number"
                                name="contracted_hours"
                                class="form-control login-input"
                                value="0"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Costo mensual
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="monthly_cost"
                                class="form-control login-input"
                                value="0"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Cantidad baterías
                            </label>

                            <input
                                type="number"
                                name="battery_quantity"
                                class="form-control login-input"
                                value="0"
                            >

                        </div>

                    </div>

                    <!-- FILA 5 (CENTRADA) -->

                    <div class="row justify-content-center">

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Estado
                            </label>

                            <select
                                name="status_id"
                                class="form-select login-input"
                                required
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                <?php foreach($statuses as $status): ?>

                                    <option value="<?php echo $status['id']; ?>">
                                        <?php echo $status['name']; ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label login-label">
                                Imagen del equipo
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control login-input"
                            >

                        </div>

                    </div>

                    <!-- OBSERVACIONES -->

                    <div class="mb-3">

                        <label class="form-label login-label">
                            Observaciones
                        </label>

                        <textarea
                            name="observations"
                            rows="4"
                            class="form-control"
                            style="border-radius:14px;"
                        ></textarea>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Guardar equipo
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>