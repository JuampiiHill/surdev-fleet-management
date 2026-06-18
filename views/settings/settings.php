<?php

require_once '../../middleware/auth.php';

$page_title = "Configuraciones";

include 'SettingsController.php';

include '../../partials/layout/app_header.php';

?>

<div class="main-content">

<?php include '../../partials/layout/topbar.php'; ?>

    <?php include '../../partials/settings/settings_cards.php'; ?>

</div>

<?php include '../../partials/settings/modals/modal_operation.php'; ?>
<?php include '../../partials/settings/modals/modal_business.php'; ?>
<?php include '../../partials/settings/modals/modal_site.php'; ?>
<?php include '../../partials/settings/modals/modal_provider.php'; ?>
<?php include '../../partials/settings/modals/modal_equipment_type.php'; ?>
<?php include '../../partials/settings/modals/modal_equipment.php'; ?>
<?php include '../../partials/settings/modals/modal_provider_adjustment.php'; ?>
<?php include '../../partials/layout/app_footer.php'; ?>