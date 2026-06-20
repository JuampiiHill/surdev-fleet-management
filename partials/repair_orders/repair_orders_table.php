<div class="table-responsive">

    <table class="table table-hover align-middle">

        <thead>
            <tr>
                <th>OR</th>
                <th>Fecha</th>
                <th>Equipo</th>
                <th>Tipo</th>
                <th>Operación</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th>Falla</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            <?php if (count($repair_orders) > 0): ?>

                <?php foreach ($repair_orders as $or): ?>

                    <tr>
                        <td>
                            <strong>
                                <?php echo $or['order_number']; ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo date(
                                'd/m/Y',
                                strtotime($or['report_date'])
                            ); ?>
                        </td>

                        <td>
                            <strong>
                                <?php echo $or['internal_number']; ?>
                            </strong>

                            <br>

                            <small class="text-muted">
                                <?php echo trim(($or['brand'] ?? '') . ' ' . ($or['model'] ?? '')); ?>
                            </small>
                        </td>

                        <td>
                            <?php echo $or['equipment_type'] ?? '-'; ?>
                        </td>

                        <td>
                            <?php echo $or['operation_name'] ?? '-'; ?>
                        </td>

                        <td>
                            <?php echo $or['provider_name'] ?? '-'; ?>
                        </td>

                        <td>
                            <?php if ($or['status'] === 'CERRADA'): ?>

                                <span class="badge bg-success">
                                    CERRADA
                                </span>

                            <?php else: ?>

                                <span class="badge bg-warning text-dark">
                                    ABIERTA
                                </span>

                            <?php endif; ?>
                        </td>

                        <td style="max-width: 260px;">
                            <?php echo mb_strimwidth(
                                $or['failure_description'] ?? '',
                                0,
                                80,
                                '...'
                            ); ?>
                        </td>

                        <td class="text-end">
                            <a
                                href="../../modules/repair_orders/repair-order-detail.php?id=<?php echo $or['id']; ?>"
                                class="btn btn-sm btn-outline-primary">
                                Ver detalle
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No se encontraron órdenes de reparación.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>