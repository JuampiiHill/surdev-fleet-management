<?php

require_once '../../middleware/auth.php';

$page_title = "Listado de equipos";

require_once 'DashboardController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content">

    <?php include '../../partials/layout/topbar.php'; ?>

    <div class="dashboard-card">

        <?php include '../../partials/dashboard/dashboard_header.php'; ?>

        <?php include '../../partials/dashboard/filters.php'; ?>

        <?php include '../../partials/dashboard/equipments_table.php'; ?>

    </div>

</div>

<?php include '../../partials/settings/modals/modal_equipment.php'; ?>
<?php include '../../partials/settings/modals/modal_operation.php'; ?>
<?php include '../../partials/settings/modals/modal_site.php'; ?>
<?php include '../../partials/settings/modals/modal_provider.php'; ?>

<?php include '../../partials/layout/app_footer.php'; ?>