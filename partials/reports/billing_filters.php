<div class="dashboard-card mb-4">

    <h4>
        Control de Facturación
    </h4>

    <form method="GET" class="row g-3">

        <div class="col-md-3">

            <label class="form-label">
                Período
            </label>

            <input
                type="month"
                class="form-control"
                name="period"
                value="<?php echo $period; ?>"
            >

        </div>

        <div class="col-md-3">

            <label class="form-label">
                Proveedor
            </label>

            <select
                name="provider_id"
                class="form-select">

                <option value="0">
                    Todos
                </option>

                <?php foreach ($providers as $provider): ?>

                    <option
                        value="<?php echo $provider['id']; ?>"
                        <?php echo ($selected_provider_id == $provider['id']) ? 'selected' : ''; ?>>
                        <?php echo $provider['name']; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="col-md-3">

            <label class="form-label">
                Operación
            </label>

            <select
                name="operation_id"
                class="form-select">

                <option value="0">
                    Todas
                </option>

                <?php foreach ($operations as $operation): ?>

                    <option
                        value="<?php echo $operation['id']; ?>"
                        <?php echo ($selected_operation_id == $operation['id']) ? 'selected' : ''; ?>>
                        <?php echo $operation['name']; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="col-md-3 d-flex align-items-end">

            <button
                type="submit"
                class="btn btn-primary w-100">
                Consultar
            </button>

        </div>

    </form>

</div>