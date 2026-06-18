<div class="dashboard-card mb-4">

    <h5>Resumen General</h5>

    <div class="row mt-3">

        <div class="col-md-3">
            <strong>Alquileres</strong><br>
            $ <?php echo number_format($summary['rental_cost'], 0, ',', '.'); ?>
        </div>

        <div class="col-md-3">
            <strong>Horas extras</strong><br>
            $ <?php echo number_format($summary['hours_extra'], 0, ',', '.'); ?>
        </div>

        <div class="col-md-3">
            <strong>Reparaciones</strong><br>
            $ <?php echo number_format($summary['repair_costs'], 0, ',', '.'); ?>
        </div>

        <div class="col-md-3">
            <strong>Total período</strong><br>
            $ <?php echo number_format($summary['total'], 0, ',', '.'); ?>
        </div>

    </div>

</div>