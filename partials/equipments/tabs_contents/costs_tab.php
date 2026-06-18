<div class="tab-pane fade" id="costs-tab">

    <div class="d-flex justify-content-end mb-3">

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#costModal">
            Registrar costo
        </button>

    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Importe</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($costs as $cost): ?>
                    <tr>
                        <td>
                            <?php echo date(
                            'd/m/Y',
                            strtotime($cost['cost_date'])
                            ); ?>
                        </td>
                        <td>
                            <?php echo $cost['cost_type']; ?>
                        </td>
                        <td>
                            <?php echo $cost['description']; ?>
                        </td>
                        <td>
                            $<?php echo number_format($cost['amount'], 0, ',', '.'); ?>
                        </td>
                        <td>
                            <?php if (!empty($cost['file'])): ?>
                                <a href="../../assets/uploads/costs/<?php echo $cost['file']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    PDF
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>