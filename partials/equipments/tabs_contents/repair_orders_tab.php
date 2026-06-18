<div
                        class="tab-pane fade"
                        id="or-tab">

                        <?php if (count($repair_orders) > 0): ?>

                            <div class="table-responsive">

                                <table class="table repair-orders-table">

                                    <thead>

                                        <tr>

                                            <th>OR</th>
                                            <th>Fecha</th>
                                            <th>Prioridad</th>
                                            <th>Reportado por</th>
                                            <th>Descripción de falla</th>
                                            <th>Estado</th>
                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($repair_orders as $or): ?>

                                            <tr>

                                                <td>

                                                    <strong>
                                                        <?php echo $or['order_number'] ?? ('OR-' . $or['id']); ?>
                                                    </strong>

                                                </td>

                                                <td>

                                                    <?php echo date(
                                                        'd/m/Y',
                                                        strtotime($or['report_date'])
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php

                                                    $priority_class =
                                                        'priority-low';

                                                    if ($or['priority'] == 'MEDIA') {
                                                        $priority_class =
                                                            'priority-medium';
                                                    }

                                                    if ($or['priority'] == 'ALTA') {
                                                        $priority_class =
                                                            'priority-high';
                                                    }

                                                    ?>

                                                    <span
                                                        class="priority-badge <?php echo $priority_class; ?>">
                                                        <?php echo $or['priority']; ?>
                                                    </span>

                                                </td>

                                                <td>
                                                    <?php echo $or['reported_by']; ?>
                                                </td>

                                                <td class="failure-column">

                                                    <?php echo mb_strimwidth($or['failure_description'], 0, 80, '...'); ?>

                                                </td>

                                                <td>

                                                    <span class="status-badge">
                                                        <?php echo $or['status']; ?>
                                                    </span>

                                                </td>

                                                <td>

                                                    <a href="../../modules/repair_orders/repair-order-detail.php?id=<?php echo $or['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        Detalle
                                                    </a>
                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php else: ?>

                            <div class="empty-state">

                                <i class="bi bi-tools"></i>

                                <h5>
                                    No existen OR registradas
                                </h5>

                                <p>
                                    Utilizá el botón "Nueva OR"
                                    para cargar la primera.
                                </p>

                            </div>

                        <?php endif; ?>

                    </div>