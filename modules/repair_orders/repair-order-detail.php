<?php

require_once '../../middleware/auth.php';

$page_title = 'Detalle OR';

include 'RepairOrderDetailController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content p-4">

    <?php include '../../partials/repair_orders/repair_order_header.php'; ?>

    <?php include '../../partials/repair_orders/repair_order_actions.php'; ?>

    <div class="row">

        <?php include '../../partials/repair_orders/work_orders_section.php'; ?>

        <?php include '../../partials/repair_orders/economic_section.php'; ?>

    </div>

</div>

<?php include '../../partials/repair_orders/modals/work_order_modal.php'; ?>
<?php include '../../partials/repair_orders/modals/close_repair_order_modal.php'; ?>
<?php include '../../partials/repair_orders/modals/quote_modal.php'; ?>
<?php include '../../partials/repair_orders/modals/invoice_modal.php'; ?>

<?php include '../../partials/layout/app_footer.php'; ?>