<?php

session_start();

require_once '../../middleware/auth.php';
require_once '../../config/database.php';
require_once 'HourController.php';

try {

    if (!isset($_GET['equipment_id'])) {

        header(
            'Location: ../dashboard/dashboard.php'
        );

        exit;
    }

    $equipment_id = (int) $_GET['equipment_id'];

    $equipment = getEquipmentById(
        $conexion,
        $equipment_id
    );

    if (!$equipment) {

        throw new Exception(
            'Equipo inexistente.'
        );
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $work_date = $_POST['work_date'] ?? '';

        $hours = (float) (
            $_POST['hours'] ?? 0
        );

        $observations = trim(
            $_POST['observations'] ?? ''
        );

        if ($hours <= 0) {

            $error =
                'Las horas trabajadas deben ser mayores a cero.';
        }

        if (empty($error)) {

            $new_hourmeter =
                (float) $equipment['current_hourmeter']
                + $hours;

            createHourLog(
                $conexion,
                $equipment_id,
                $work_date,
                $hours,
                $new_hourmeter,
                $observations,
                $_SESSION['user_id'] ?? null
            );

            updateEquipmentHourmeter(
                $conexion,
                $equipment_id,
                $new_hourmeter
            );

            header(
                'Location: ../../views/equipments/equipment_detail.php?id=' .
                $equipment_id
            );

            exit;
        }
    }

} catch (Exception $e) {

    error_log(
        'Error register-hours: ' .
        $e->getMessage()
    );

    die(
        'Ocurrió un error al registrar las horas.'
    );
}