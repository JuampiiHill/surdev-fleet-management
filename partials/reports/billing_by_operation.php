<div class="col-md-12 mb-4">

    <div class="dashboard-card">

        <h5>Costos por Operación</h5>

        <div class="table-responsive mt-3">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Operación</th>
                        <th>Alquiler</th>
                        <th>Horas extras</th>
                        <th>Reparaciones</th>
                        <th>Otros</th>
                        <th>Recuperos</th>
                        <th>Indisp.</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($billing_by_operation) > 0): ?>

                        <?php foreach ($billing_by_operation as $row): ?>

                            <?php
                                $total =
                                    (float)$row['rental_cost']
                                    + (float)$row['hours_extra']
                                    + (float)$row['repair_costs']
                                    + (float)$row['other_costs']
                                    - (float)$row['recoveries']
                                    - (float)$row['downtime_discount'];

                                $detail_url =
                                    'reports.php?period=' .
                                    urlencode($period) .
                                    '&operation_id=' .
                                    (int)$row['operation_id'];

                                if ($selected_provider_id > 0) {

                                    $detail_url .=
                                        '&provider_id=' .
                                        $selected_provider_id;
                                }
                            ?>

                            <tr>
                                <td>
                                    <?php echo $row['operation_name'] ?? 'Sin operación'; ?>
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
                            <td
                                colspan="9"
                                class="text-center text-muted py-4">
                                No hay datos para el período seleccionado.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>