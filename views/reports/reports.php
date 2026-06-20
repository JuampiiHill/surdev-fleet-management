<?php

require_once '../../middleware/auth.php';

$page_title = "Reportes";

include 'ReportsController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content">

    <?php include '../../partials/layout/topbar.php'; ?>

    <?php include '../../partials/reports/billing_filters.php'; ?>

    <?php include '../../partials/reports/billing_summary.php'; ?>

    <?php include '../../partials/reports/billing_equipment_detail.php'; ?>

</div>

<?php include '../../partials/layout/app_footer.php'; ?>