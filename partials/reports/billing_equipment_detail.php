<div class="dashboard-card mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h5 class="mb-1">
                Detalle por equipo
            </h5>

            <p class="text-muted mb-0">
                Control mensual por proveedor, operación y equipo.
            </p>
        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Operación</th>
                    <th>Interno</th>
                    <th>Tipo</th>
                    <th>Equipo</th>
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
                            $total =
                                (float) $row['rental_cost']
                                + (float) $row['hours_extra']
                                + (float) $row['repair_costs']
                                + (float) $row['other_costs']
                                - (float) $row['recoveries']
                                - (float) $row['downtime_discount'];
                        ?>

                        <tr>
                            <td>
                                <?php echo $row['provider_name'] ?? 'Sin proveedor'; ?>
                            </td>

                            <td>
                                <?php echo $row['operation_name'] ?? 'Sin operación'; ?>
                            </td>

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
                        <td colspan="13" class="text-center text-muted py-4">
                            No hay equipos para el período o filtros seleccionados.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>