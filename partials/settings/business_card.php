<div class="col-md-12 mb-4">

    <div class="dashboard-card">

        <h5>Costos por Negocio</h5>

        <div class="table-responsive mt-3">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Negocio</th>
                        <th>Alquiler</th>
                        <th>Horas extras</th>
                        <th>Reparaciones</th>
                        <th>Otros</th>
                        <th>Recuperos</th>
                        <th>Indisp.</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($billing_by_business) > 0): ?>

                        <?php foreach ($billing_by_business as $row): ?>

                            <?php
                                $total =
                                    (float)$row['rental_cost']
                                    + (float)$row['hours_extra']
                                    + (float)$row['repair_costs']
                                    + (float)$row['other_costs']
                                    - (float)$row['recoveries']
                                    - (float)$row['downtime_discount'];
                            ?>

                            <tr>
                                <td>
                                    <?php echo $row['business_name'] ?? 'Sin negocio'; ?>
                                </td>

                                <td>
                                    $ <?php echo number_format($row['rental_cost'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    $ <?php echo number_format($row['hours_extra'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    $ <?php echo number_format($row['repair_costs'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    $ <?php echo number_format($row['other_costs'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    -$ <?php echo number_format($row['recoveries'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    -$ <?php echo number_format($row['downtime_discount'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <strong>
                                        $ <?php echo number_format($total, 0, ',', '.'); ?>
                                    </strong>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay datos por negocio para el período seleccionado.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>