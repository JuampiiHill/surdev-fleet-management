    <a
        href="../../views/equipments/equipment_detail.php?id=<?php echo $repair_order['equipment_id']; ?>"
        class="btn btn-outline-secondary mb-4">
        ← Volver al Equipo
    </a>

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h2 class="mb-1">
                        <?php echo $repair_order['order_number']; ?>
                    </h2>

                    <p class="text-muted mb-0">

                        Equipo:

                        <strong>

                            <?php echo $repair_order['internal_number']; ?>

                        </strong>

                        -

                        <?php echo $repair_order['brand']; ?>

                        <?php echo $repair_order['model']; ?>

                    </p>

                </div>

                <div>

                    <span class="badge bg-primary">

                        <?php echo $repair_order['status']; ?>

                    </span>

                </div>

            </div>

            <hr>

            <h5>
                Descripción de Falla
            </h5>

            <p>
                <?php echo nl2br($repair_order['failure_description']); ?>
            </p>

            <?php if (!empty($repair_order['file'])): ?>

                <a href="../../assets/uploads/repair_orders/<?php echo $repair_order['file']; ?> " target="_blank" class="btn btn-outline-primary">
                    Ver OR Original
                </a>

            <?php endif; ?>

        </div>

    </div>