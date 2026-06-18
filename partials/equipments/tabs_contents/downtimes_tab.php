<div
                        class="tab-pane fade"
                        id="downtime-tab">

                        <?php if (count($downtimes) > 0): ?>

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>

                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Días</th>
                                            <th>Bonificación</th>
                                            <th>Motivo</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($downtimes as $dt): ?>

                                            <tr>

                                                <td>

                                                    <?php echo date(
                                                        'd/m/Y',
                                                        strtotime($dt['start_date'])
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php echo date(
                                                        'd/m/Y',
                                                        strtotime($dt['end_date'])
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php echo $dt['days']; ?>

                                                </td>

                                                <td>

                                                    $

                                                    <?php echo number_format(

                                                        $dt['manual_discount']
                                                            ?: $dt['calculated_discount'],

                                                        0,
                                                        ',',
                                                        '.'

                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?php echo $dt['reason']; ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php else: ?>

                            <div class="alert alert-light">

                                Sin indisponibilidades registradas.

                            </div>

                        <?php endif; ?>

                    </div>