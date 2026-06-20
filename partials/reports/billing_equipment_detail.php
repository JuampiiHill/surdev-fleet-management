<div class="dashboard-card mt-4">

    <?php
        $total_rental = 0;
        $total_hours_extra = 0;
        $total_repairs = 0;
        $total_other = 0;
        $total_recoveries = 0;
        $total_downtime = 0;
        $grand_total = 0;
    ?>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h5 class="mb-1">
                Control de facturación por equipo
            </h5>

            <p class="text-muted mb-0">
                Detalle mensual para comparar contra la factura recibida.
            </p>
        </div>

        <div>
            <a href="../../controllers/reports/export_billing_csv.php?period=<?php echo urlencode($period); ?>&provider_id=<?php echo $selected_provider_id; ?>&operation_id=<?php echo $selected_operation_id; ?>"class="btn btn-outline-success">
                Exportar Excel
            </a>
        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>Interno</th>
                    <th>Tipo</th>
                    <th>Equipo</th>
                    <th>Proveedor</th>
                    <th>Operación</th>
                    <th>Alquiler</th>
                    <th>Hs extra</th>
                    <th>Reparaciones</th>
                    <th>Otros</th>
                    <th>Recuperos</th>
                    <th>Indisp.</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

                <?php if (count($billing_equipment_detail) > 0): ?>

                    <?php foreach ($billing_equipment_detail as $row): ?>

                        <?php
                            $rental =
                                (float) $row['rental_cost'];

                            $hours_extra =
                                (float) $row['hours_extra'];

                            $repairs =
                                (float) $row['repair_costs'];

                            $other =
                                (float) $row['other_costs'];

                            $recoveries =
                                (float) $row['recoveries'];

                            $downtime =
                                (float) $row['downtime_discount'];

                            $total =
                                $rental
                                + $hours_extra
                                + $repairs
                                + $other
                                - $recoveries
                                - $downtime;

                            $total_rental += $rental;
                            $total_hours_extra += $hours_extra;
                            $total_repairs += $repairs;
                            $total_other += $other;
                            $total_recoveries += $recoveries;
                            $total_downtime += $downtime;
                            $grand_total += $total;
                        ?>

                        <tr>
                            <td>
                                <strong>
                                    <?php echo $row['internal_number']; ?>
                                </strong>
                            </td>

                            <td>
                                <?php echo $row['equipment_type'] ?? '-'; ?>
                            </td>

                            <td>
                                <?php echo trim(($row['brand'] ?? '') . ' ' . ($row['model'] ?? '')); ?>
                            </td>

                            <td>
                                <?php echo $row['provider_name'] ?? 'Sin proveedor'; ?>
                            </td>

                            <td>
                                <?php echo $row['operation_name'] ?? 'Sin operación'; ?>
                            </td>

                            <td>
                                $ <?php echo number_format($rental, 0, ',', '.'); ?>
                            </td>

                            <td>
                                $ <?php echo number_format($hours_extra, 0, ',', '.'); ?>
                            </td>

                            <td>
                                $ <?php echo number_format($repairs, 0, ',', '.'); ?>
                            </td>

                            <td>
                                $ <?php echo number_format($other, 0, ',', '.'); ?>
                            </td>

                            <td>
                                -$ <?php echo number_format($recoveries, 0, ',', '.'); ?>
                            </td>

                            <td>
                                -$ <?php echo number_format($downtime, 0, ',', '.'); ?>
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
                        <td colspan="12" class="text-center text-muted py-4">
                            No hay equipos para el período o filtros seleccionados.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

            <?php if (count($billing_equipment_detail) > 0): ?>

                <tfoot>
                    <tr>
                        <th colspan="5">
                            Totales
                        </th>

                        <th>
                            $ <?php echo number_format($total_rental, 0, ',', '.'); ?>
                        </th>

                        <th>
                            $ <?php echo number_format($total_hours_extra, 0, ',', '.'); ?>
                        </th>

                        <th>
                            $ <?php echo number_format($total_repairs, 0, ',', '.'); ?>
                        </th>

                        <th>
                            $ <?php echo number_format($total_other, 0, ',', '.'); ?>
                        </th>

                        <th>
                            -$ <?php echo number_format($total_recoveries, 0, ',', '.'); ?>
                        </th>

                        <th>
                            -$ <?php echo number_format($total_downtime, 0, ',', '.'); ?>
                        </th>

                        <th>
                            <strong>
                                $ <?php echo number_format($grand_total, 0, ',', '.'); ?>
                            </strong>
                        </th>
                    </tr>
                </tfoot>

            <?php endif; ?>

        </table>

    </div>

</div>