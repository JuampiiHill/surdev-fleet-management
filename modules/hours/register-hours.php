<?php

session_start();

require_once '../../config/database.php';

if(!isset($_GET['equipment_id'])){
    header('Location: ../dashboard/dashboard.php');
    exit;
}

$equipment_id = $_GET['equipment_id'];

/* =============
   BUSCAR EQUIPO
============= */

$sql = "
    SELECT
        id,
        internal_number,
        brand,
        model,
        current_hourmeter
    FROM equipments
    WHERE id = :id
";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $equipment_id);
$stmt->execute();

$equipment = $stmt->fetch();

if(!$equipment){
    header('Location: ../dashboard/dashboard.php');
    exit;
}

/* =========
   GUARDAR
========= */

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $work_date = $_POST['work_date'];
    $hours = (float)$_POST['hours'];
    $observations = trim($_POST['observations']);

    if($hours <= 0){
        $error = 'Las horas trabajadas deben ser mayores a cero.';
    }

    if(empty($error)){

        /*====================
        CALCULAR NUEVO HORÓMETRO
        ======================= */

        $nuevo_horometro =
            (float)$equipment['current_hourmeter']
            +
            $hours;

        /*===============
        INSERT LOG DE HORAS
        =================*/

        $sql_insert = "
            INSERT INTO equipment_hour_logs
            (
                equipment_id,
                work_date,
                hours,
                hourmeter,
                observations,
                created_by
            )
            VALUES
            (
                :equipment_id,
                :work_date,
                :hours,
                :hourmeter,
                :observations,
                :created_by
            )
        ";

        $stmt_insert = $conexion->prepare($sql_insert);

        $stmt_insert->execute([
            ':equipment_id' => $equipment_id,
            ':work_date' => $work_date,
            ':hours' => $hours,
            ':hourmeter' => $nuevo_horometro,
            ':observations' => $observations,
            ':created_by' => $_SESSION['user_id'] ?? null
        ]);

        /*=====================
        ACTUALIZAR HORÓMETRO DEL EQUIPO
        ======================== */

        $sql_update = "
            UPDATE equipments
            SET current_hourmeter = :hourmeter
            WHERE id = :equipment_id
        ";

        $stmt_update = $conexion->prepare($sql_update);

        $stmt_update->execute([
            ':hourmeter' => $nuevo_horometro,
            ':equipment_id' => $equipment_id
        ]);

        header(
            'Location: ../../views/equipments/equipment_detail.php?id=' .
            $equipment_id
        );
        exit;
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="main-content">

    <div class="dashboard-card">

        <h2 class="mb-4">
            Registrar Horas
        </h2>

        <div class="mb-3">

            <h5 class="mb-0">

                <?php echo $equipment['internal_number']; ?>

                -

                <?php echo $equipment['brand']; ?>

                <?php echo $equipment['model']; ?>

            </h5>

        </div>

        <div class="alert alert-info">

            <strong>
                Horómetro actual:
            </strong>

            <?php echo number_format(
                $equipment['current_hourmeter'],
                2,
                ',',
                '.'
            ); ?>

            hs

        </div>

        <?php if(!empty($error)): ?>

            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Fecha
                    </label>

                    <input
                        type="date"
                        name="work_date"
                        class="form-control"
                        value="<?php echo date('Y-m-d'); ?>"
                        required
                    >

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Horas trabajadas
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        min="0.01"
                        name="hours"
                        class="form-control"
                        required
                    >

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Observaciones
                </label>

                <textarea
                    name="observations"
                    class="form-control"
                    rows="4"
                ></textarea>

            </div>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar Horas
            </button>

            <a
                href="../../views/equipments/equipment_detail.php?id=<?php echo $equipment_id; ?>"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

        </form>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>