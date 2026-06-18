 <div
                        class="tab-pane fade"
                        id="ot-tab">

                        <?php if (count($work_orders) > 0): ?>

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>

                                            <th>OT</th>
                                            <th>Fecha</th>
                                            <th>Técnico</th>
                                            <th>OR Asociada</th>
                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($work_orders as $wo): ?>

                                            <tr>

                                                <td>

                                                    <?php echo $wo['work_order_number']; ?>

                                                </td>

                                                <td>

                                                    <?php echo date(
                                                        'd/m/Y',
                                                        strtotime($wo['work_date'])
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php echo $wo['mechanic_name']; ?>

                                                </td>

                                                <td>

                                                    <?php echo $wo['order_number']; ?>

                                                </td>

                                                <td>

                                                    <?php if (!empty($wo['file'])): ?>

                                                        <a
                                                            href="../../assets/uploads/repair_orders/<?php echo $wo['file']; ?>"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Ver PDF
                                                        </a>

                                                    <?php endif; ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php else: ?>

                            <div class="empty-state">

                                <h5>
                                    No existen OT registradas
                                </h5>

                            </div>

                        <?php endif; ?>

                    </div>