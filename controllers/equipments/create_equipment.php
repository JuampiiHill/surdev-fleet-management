<?php

session_start();

require_once '../../config/database.php';

try {

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        header('Location: ../../views/dashboard/dashboard.php');
        exit;
    }

    /* =====================
       CAPTURAS DEL FORM
    ========================= */

    $internal_number =
        trim($_POST['internal_number'] ?? '');

    $brand =
        trim($_POST['brand'] ?? '');

    $model =
        trim($_POST['model'] ?? '');

    $year =
        !empty($_POST['year'])
            ? (int) $_POST['year']
            : null;

    $serial_number =
        trim($_POST['serial_number'] ?? '');

    $equipment_type_id =
        (int) ($_POST['equipment_type_id'] ?? 0);

    $operation_id =
        (int) ($_POST['operation_id'] ?? 0);

    $provider_id =
        (int) ($_POST['provider_id'] ?? 0);

    $initial_hourmeter =
        !empty($_POST['initial_hourmeter'])
            ? (float) $_POST['initial_hourmeter']
            : 0;

    $maintenance_interval_hours =
        !empty($_POST['maintenance_interval_hours'])
            ? (int) $_POST['maintenance_interval_hours']
            : 250;

    $contracted_hours =
        !empty($_POST['contracted_hours'])
            ? (int) $_POST['contracted_hours']
            : 0;

    $monthly_cost =
        !empty($_POST['monthly_cost'])
            ? (float) $_POST['monthly_cost']
            : 0;

    $battery_quantity =
        !empty($_POST['battery_quantity'])
            ? (int) $_POST['battery_quantity']
            : 0;

    $status_id =
        (int) ($_POST['status_id'] ?? 0);

    $observations =
        trim($_POST['observations'] ?? '');

    if (
        empty($internal_number) ||
        empty($model) ||
        $equipment_type_id <= 0 ||
        $operation_id <= 0 ||
        $provider_id <= 0 ||
        $status_id <= 0
    ) {
        throw new Exception('Datos obligatorios incompletos.');
    }

    /* ==========================================
       OBTENER NEGOCIO Y SITE DESDE OPERACIÓN
    =========================================== */

    $sql_operation = "
        SELECT
            business_id,
            site_id
        FROM operations
        WHERE id = ?
    ";

    $stmt_operation =
        $conexion->prepare($sql_operation);

    $stmt_operation->execute([
        $operation_id
    ]);

    $operation_data =
        $stmt_operation->fetch();

    if (!$operation_data) {
        throw new Exception('Operación inválida.');
    }

    $business_id =
        $operation_data['business_id'];

    $site_id =
        $operation_data['site_id'];

    $image_name = null;

    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0
    ) {

        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $file_name =
            $_FILES['image']['name'];

        $tmp_name =
            $_FILES['image']['tmp_name'];

        $extension =
            strtolower(
                pathinfo(
                    $file_name,
                    PATHINFO_EXTENSION
                )
            );

        if (in_array($extension, $allowed_extensions)) {

            $image_name =
                uniqid() . '.' . $extension;

            $destination =
                '../../assets/uploads/equipments/' .
                $image_name;

            move_uploaded_file(
                $tmp_name,
                $destination
            );
        }
    }

    $conexion->beginTransaction();

    /* ============
       INSERT EQUIPO
    ============ */

    $sql = "
        INSERT INTO equipments (

            internal_number,
            serial_number,
            brand,
            model,
            year,
            battery_quantity,
            equipment_type_id,
            provider_id,
            business_id,
            operation_id,
            site_id,
            contracted_hours,
            monthly_cost,
            status_id,
            active,
            observations,
            image,
            initial_hourmeter,
            current_hourmeter,
            maintenance_interval_hours,
            rental_start_date

        )
        VALUES (

            :internal_number,
            :serial_number,
            :brand,
            :model,
            :year,
            :battery_quantity,
            :equipment_type_id,
            :provider_id,
            :business_id,
            :operation_id,
            :site_id,
            :contracted_hours,
            :monthly_cost,
            :status_id,
            1,
            :observations,
            :image,
            :initial_hourmeter,
            :initial_hourmeter,
            :maintenance_interval_hours,
            CURDATE()

        )
    ";

    $stmt =
        $conexion->prepare($sql);

    $stmt->execute([
        ':internal_number' => $internal_number,
        ':serial_number' => $serial_number,
        ':brand' => $brand,
        ':model' => $model,
        ':year' => $year,
        ':battery_quantity' => $battery_quantity,
        ':equipment_type_id' => $equipment_type_id,
        ':provider_id' => $provider_id,
        ':business_id' => $business_id,
        ':operation_id' => $operation_id,
        ':site_id' => $site_id,
        ':contracted_hours' => $contracted_hours,
        ':monthly_cost' => $monthly_cost,
        ':status_id' => $status_id,
        ':observations' => $observations,
        ':image' => $image_name,
        ':initial_hourmeter' => $initial_hourmeter,
        ':maintenance_interval_hours' => $maintenance_interval_hours
    ]);

    $equipment_id =
        $conexion->lastInsertId();

    /* ======================================
       CREAR TARIFA MENSUAL PARA REPORTES
    ======================================= */

    $period_year =
        (int) date('Y');

    $period_month =
        (int) date('m');

    $sql_monthly_rate = "
        INSERT INTO equipment_monthly_rates (

            equipment_id,
            provider_id,
            operation_id,
            business_id,
            site_id,
            monthly_cost,
            contracted_hours,
            period_year,
            period_month,
            active

        )
        VALUES (

            :equipment_id,
            :provider_id,
            :operation_id,
            :business_id,
            :site_id,
            :monthly_cost,
            :contracted_hours,
            :period_year,
            :period_month,
            1

        )
    ";

    $stmt_monthly_rate =
        $conexion->prepare($sql_monthly_rate);

    $stmt_monthly_rate->execute([
        ':equipment_id' => $equipment_id,
        ':provider_id' => $provider_id,
        ':operation_id' => $operation_id,
        ':business_id' => $business_id,
        ':site_id' => $site_id,
        ':monthly_cost' => $monthly_cost,
        ':contracted_hours' => $contracted_hours,
        ':period_year' => $period_year,
        ':period_month' => $period_month
    ]);

    $conexion->commit();

    header(
        'Location: ../../views/dashboard/dashboard.php'
    );

    exit;

} catch (Exception $e) {

    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }

    error_log(
        'Error create_equipment: ' .
        $e->getMessage()
    );

    die(
        $e->getMessage()
    );
}