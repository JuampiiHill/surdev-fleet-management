<form method="GET" class="filters mb-4" id="repairOrdersFiltersForm">

    <div>
        <label class="filter-label">
            Estado
        </label>

        <select
            name="status"
            class="form-select"
            onchange="document.getElementById('repairOrdersFiltersForm').submit();">

            <option value="">
                Todas
            </option>

            <option
                value="ABIERTA"
                <?php echo ($selected_status === 'ABIERTA') ? 'selected' : ''; ?>>
                Abiertas
            </option>

            <option
                value="CERRADA"
                <?php echo ($selected_status === 'CERRADA') ? 'selected' : ''; ?>>
                Cerradas
            </option>

        </select>
    </div>

    <div>
        <label class="filter-label">
            Operación
        </label>

        <select
            name="operation_id"
            class="form-select"
            onchange="document.getElementById('repairOrdersFiltersForm').submit();">

            <option value="0">
                Todas las operaciones
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

    <div>
        <label class="filter-label">
            Buscar
        </label>

        <input
            type="text"
            name="search"
            id="repairOrdersSearchInput"
            class="form-control"
            placeholder="Buscar OR, interno o falla..."
            value="<?php echo htmlspecialchars($search); ?>"
        >
    </div>

    <div class="d-flex align-items-end gap-2">

        <a href="repair_orders.php" class="btn btn-outline-secondary">
            Limpiar
        </a>

    </div>

</form>

<script>
let repairOrdersSearchTimer = null;

const repairOrdersSearchInput =
    document.getElementById('repairOrdersSearchInput');

const repairOrdersFiltersForm =
    document.getElementById('repairOrdersFiltersForm');

if (repairOrdersSearchInput && repairOrdersFiltersForm) {

    repairOrdersSearchInput.addEventListener('input', function () {

        clearTimeout(repairOrdersSearchTimer);

        repairOrdersSearchTimer =
            setTimeout(function () {
                repairOrdersFiltersForm.submit();
            }, 500);

    });

}
</script>