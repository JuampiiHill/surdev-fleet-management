<?php

require_once '../../middleware/auth.php';

$page_title = 'Detalle de equipo';

include 'EquipmentDetailController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content equipment-detail-layout">

    <?php include '../../partials/equipments/detail_topbar.php'; ?>

    <?php include '../../partials/equipments/equipment_header.php'; ?>
    <?php include '../../partials/equipments/modals/hour_modal.php'; ?>

    <div class="detail-content">

        <?php include '../../partials/equipments/equipment_cards.php'; ?>

        <div class="second-row-grid mt-4">

            <div class="detail-card">

                <?php include '../../partials/equipments/tabs.php'; ?>

            </div>

            <?php include '../../partials/equipments/costs_sidebar.php'; ?>

        </div>

    </div>

</div>

<?php include '../../partials/equipments/modals/preventive_modal.php'; ?>
<?php include '../../partials/equipments/modals/change_location_modal.php'; ?>
<?php include '../../partials/equipments/modals/repair_order_modal.php'; ?>
<?php include '../../partials/equipments/modals/downtime_modal.php'; ?>
<?php include '../../partials/equipments/modals/cost_modal.php'; ?>

<script>
const equipmentData = {
    months: <?php echo json_encode($months); ?>,
    chartHours: <?php echo json_encode($chart_hours); ?>,
    monthlyRate: <?php echo (float)$equipment['monthly_cost']; ?>
};
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../assets/js/equipment-detail.js"></script>

<?php include '../../partials/layout/app_footer.php'; ?>