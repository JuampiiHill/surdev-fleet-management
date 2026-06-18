<div class="col-md-6">

    <div class="card shadow-sm h-100">

        <div class="card-header">

            <h4 class="mb-0">
                Información Económica
            </h4>

        </div>

        <div class="card-body">

            <h5>Presupuestos</h5>

            <?php if (count($quotes) > 0): ?>

                <?php foreach ($quotes as $quote): ?>

                    <div class="border rounded p-2 mb-2">

                        <strong>
                            Presupuesto Nº <?php echo $quote['quote_number']; ?>
                        </strong>

                        <br>

                        Fecha:
                        <?php echo date(
                            'd/m/Y',
                            strtotime($quote['quote_date'])
                        ); ?>

                        <br>

                        Monto:
                        $<?php echo number_format(
                                $quote['amount'],
                                0,
                                ',',
                                '.'
                            ); ?>

                        <div class="mt-2">

                            <?php if (!empty($quote['file_1'])): ?>

                                <a
                                    href="../../assets/uploads/repair_quotes/<?php echo $quote['file_1']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    PDF 1
                                </a>

                            <?php endif; ?>

                            <?php if (!empty($quote['file_2'])): ?>

                                <a
                                    href="../../assets/uploads/repair_quotes/<?php echo $quote['file_2']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    PDF 2
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="alert alert-light">
                    Sin presupuestos cargados.
                </div>

            <?php endif; ?>

            <hr>

            <h5>Facturas</h5>

            <?php if (count($invoices) > 0): ?>

                <?php foreach ($invoices as $invoice): ?>

                    <div class="border rounded p-2 mb-2">

                        <strong>
                            Factura Nº <?php echo $invoice['invoice_number']; ?>
                        </strong>

                        <br>

                        Fecha:
                        <?php echo date(
                            'd/m/Y',
                            strtotime($invoice['invoice_date'])
                        ); ?>

                        <br>

                        Monto:
                        $<?php echo number_format(
                                $invoice['amount'],
                                0,
                                ',',
                                '.'
                            ); ?>

                        <?php if (!empty($invoice['file'])): ?>

                            <div class="mt-2">

                                <a
                                    href="../../assets/uploads/repair_invoices/<?php echo $invoice['file']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-warning">
                                    Ver Factura
                                </a>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="alert alert-light">
                    Sin facturas cargadas.
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>