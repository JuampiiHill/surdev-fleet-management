<div
                        class="tab-pane fade"
                        id="preventive-tab">

                        <?php if (count($preventives) > 0): ?>

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>

                                            <th>Fecha</th>
                                            <th>Horómetro</th>
                                            <th>Observaciones</th>
                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($preventives as $pm): ?>

                                            <tr>

                                                <td>

                                                    <?php echo date(
                                                        'd/m/Y',
                                                        strtotime($pm['maintenance_date'])
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php echo number_format(
                                                        $pm['hourmeter'],
                                                        0,
                                                        ',',
                                                        '.'
                                                    ); ?>

                                                    hs

                                                </td>

                                                <td>

                                                    <?php echo mb_strimwidth(
                                                        $pm['observations'],
                                                        0,
                                                        80,
                                                        '...'
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php if (!empty($pm['file'])): ?>

                                                        <a
                                                            href="../../assets/uploads/maintenances/<?php echo $pm['file']; ?>"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-success">
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
                                    No existen mantenimientos preventivos registrados
                                </h5>

                            </div>

                        <?php endif; ?>

                    </div>