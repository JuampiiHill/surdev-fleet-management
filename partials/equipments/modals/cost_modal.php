<div
    class="modal fade"
    id="costModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="../../controllers/costs/create_cost.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="equipment_id"
                    value="<?php echo $equipment['id']; ?>">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Registrar costo

                    </h5>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Fecha</label>

                            <input
                                type="date"
                                name="cost_date"
                                class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Tipo</label>

                            <select
                                name="cost_type"
                                class="form-select"
                                required>

                                <option value="">
                                    Seleccionar
                                </option>

                                <option value="HORAS_EXTRAS">
                                    Horas Extras
                                </option>

                                <option value="TRASLADO">
                                    Traslado
                                </option>

                                <option value="RECUPERO">
                                    Recupero
                                </option>

                                <option value="OTROS">
                                    Otros
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>Descripción</label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"></textarea>

                    </div>

                    <div class="mb-3">

                        <label>Importe</label>

                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Factura PDF</label>

                        <input
                            type="file"
                            name="file"
                            class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-success">
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>