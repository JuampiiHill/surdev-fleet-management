<?php

require_once '../../middleware/auth.php';

$page_title = "Órdenes de Reparación";

include 'RepairOrdersController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content">

    <?php include '../../partials/layout/topbar.php'; ?>

    <div class="dashboard-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="mb-1">
                    Órdenes de Reparación
                </h2>

                <p class="text-muted mb-0">
                    Consulta general de OR abiertas y cerradas.
                </p>
            </div>

        </div>

        <?php include '../../partials/repair_orders/repair_orders_filters.php'; ?>

        <?php include '../../partials/repair_orders/repair_orders_table.php'; ?>

    </div>

</div>

<?php include '../../partials/layout/app_footer.php'; ?>