<div class="detail-card costs-card">

                <h3 class="card-title">
                    Costos del período
                </h3>

                <div class="cost-row">
                    <span>Alquiler mensual</span>
                    <strong>
                        $ <?php echo number_format($monthly_cost, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="cost-row">
                    <span>Reparaciones</span>
                    <strong>
                        $ <?php echo number_format($repair_cost, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="cost-row">
                    <span>Otros costos</span>
                    <strong>
                        $ <?php echo number_format($extra_costs, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="cost-row">
                    <span>Recuperos</span>
                    <strong>
                        -$ <?php echo number_format($recoveries, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="cost-row">
                    <span>Indisponibilidades</span>
                    <strong>
                        -$ <?php echo number_format($downtime_discount, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="cost-row cost-total">
                    <span>Total mes actual</span>
                    <strong>
                        $ <?php echo number_format($total_month_cost, 0, ',', '.'); ?>
                    </strong>
                </div>

                <div class="mt-4">

                    <button class="btn btn-outline-primary w-100">

                        Ver detalle de costos

                    </button>

                </div>

            </div>