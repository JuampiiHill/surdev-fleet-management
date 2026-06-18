<div class="col-md-6">

    <div class="card shadow-sm h-100">

        <div class="card-header">

            <h4 class="mb-0">
                Historial de OT
            </h4>

        </div>

        <div class="card-body">

            <?php if (count($work_orders) > 0): ?>

                <?php foreach ($work_orders as $wo): ?>

                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($wo['work_date'])
                                ); ?>
                            </strong>

                            <span>
                                <?php echo $wo['mechanic_name']; ?>
                            </span>

                        </div>

                        <hr>

                        <p>
                            <?php echo nl2br($wo['work_description']); ?>
                        </p>

                        <?php if (!empty($wo['work_order_number'])): ?>

                            <small class="text-muted">
                                OT Nº:
                                <?php echo $wo['work_order_number']; ?>
                            </small>

                        <?php endif; ?>

                        <?php if (!empty($wo['file'])): ?>

                            <div class="mt-2">

                                <a
                                    href="../../assets/uploads/repair_orders/<?php echo $wo['file']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    Ver OT
                                </a>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="alert alert-info">

                    No existen OT cargadas para esta OR.

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>