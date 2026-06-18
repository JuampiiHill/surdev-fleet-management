<div class="equipment-header-bar">

        <div class="equipment-header-left">

            <h1>
                Equipo: <?php echo $equipment['internal_number']; ?>
            </h1>

            <span class="equipment-subtitle">
                <?php echo strtoupper($equipment['equipment_type']); ?>
            </span>

            <?php if (!empty($equipment['status_name'])): ?>

                <span class="equipment-status-badge">
                    <?php echo strtoupper($equipment['status_name']); ?>
                </span>

            <?php endif; ?>

        </div>

        <div class="equipment-header-actions">

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hoursModal">
                Registrar Horas
            </button>

            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#repairOrderModal">
                Nueva OR
            </button>

            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#preventiveModal">
                Registrar Preventivo
            </button>

            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#downtimeModal">
                Indisponibilidad
            </button>

        </div>

    </div>