<form method="GET" class="filters" id="dashboardFiltersForm">

    <div>
        <label class="filter-label">
            Operación
        </label>

        <select name="operation_id" class="form-select" onchange="document.getElementById('dashboardFiltersForm').submit();">

            <option value="0">
                Todas las operaciones
            </option>

            <?php foreach ($operations as $op): ?>

                <option
                    value="<?php echo $op['id']; ?>"
                    <?php echo ($selected_operation_id == $op['id']) ? 'selected' : ''; ?>>
                    <?php echo $op['name']; ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div>
        <label class="filter-label">
            Negocio
        </label>

        <select name="business_id" class="form-select" onchange="document.getElementById('dashboardFiltersForm').submit();">

            <option value="0">
                Todos los negocios
            </option>

            <?php foreach ($business as $b): ?>

                <option
                    value="<?php echo $b['id']; ?>"
                    <?php echo ($selected_business_id == $b['id']) ? 'selected' : ''; ?>>
                    <?php echo $b['name']; ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div>
        <label class="filter-label">
            Site
        </label>

        <select name="site_id" class="form-select" onchange="document.getElementById('dashboardFiltersForm').submit();">

            <option value="0">
                Todos los sites
            </option>

            <?php foreach ($sites as $site): ?>

                <option
                    value="<?php echo $site['id']; ?>"
                    <?php echo ($selected_site_id == $site['id']) ? 'selected' : ''; ?>>
                    <?php echo $site['name']; ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div>
    <label class="filter-label">
        Tipo de equipo
    </label>

    <select
        name="equipment_type_id"
        class="form-select"
        onchange="document.getElementById('dashboardFiltersForm').submit();">

        <option value="0">
            Todos los tipos
        </option>

        <?php foreach ($equipments_types as $type): ?>

            <option
                value="<?php echo $type['id']; ?>"
                <?php echo ($selected_equipment_type_id == $type['id']) ? 'selected' : ''; ?>>
                <?php echo $type['type']; ?>
            </option>

        <?php endforeach; ?>

    </select>
</div>

    <div>
        <label class="filter-label">
            Proveedor
        </label>

        <select name="provider_id" class="form-select" onchange="document.getElementById('dashboardFiltersForm').submit();">

            <option value="0">
                Todos los proveedores
            </option>

            <?php foreach ($providers as $p): ?>

                <option
                    value="<?php echo $p['id']; ?>"
                    <?php echo ($selected_provider_id == $p['id']) ? 'selected' : ''; ?>>
                    <?php echo $p['name']; ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div>

    <!-- <div>
        <label class="filter-label">
            Estado
        </label>

        <select name="status_id" class="form-select" onchange="document.getElementById('dashboardFiltersForm').submit();">

            <option value="0">
                Todos
            </option>

            <?php foreach ($statuses as $status): ?>

                <option
                    value="<?php echo $status['id']; ?>"
                    <?php echo ($selected_status_id == $status['id']) ? 'selected' : ''; ?>>
                    <?php echo $status['name']; ?>
                </option>

            <?php endforeach; ?>

        </select>
    </div> -->

    <div>
        <label class="filter-label">
            Buscar
        </label>

        <input
            type="text"
            name="search"
            id="dashboardSearchInput"
            class="form-control"
            placeholder="Buscar equipo..."
            value="<?php echo htmlspecialchars($search); ?>"
        >
    </div>

    <!--<div class="d-flex align-items-end gap-2">

        <a href="dashboard.php" class="btn btn-outline-secondary">
            Limpiar
        </a> 

    </div> -->

</form>

<script>
let dashboardSearchTimer = null;

const dashboardSearchInput = document.getElementById('dashboardSearchInput');
const dashboardFiltersForm = document.getElementById('dashboardFiltersForm');

if (dashboardSearchInput && dashboardFiltersForm) {

    dashboardSearchInput.addEventListener('input', function () {

        clearTimeout(dashboardSearchTimer);

        dashboardSearchTimer = setTimeout(function () {
            dashboardFiltersForm.submit();
        }, 500);

    });

}
</script>