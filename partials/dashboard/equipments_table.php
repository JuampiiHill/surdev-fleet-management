<div class="table-responsive">

    <table class="table table-hover align-middle">

        <thead>
            <tr>
                <th>Operación</th>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Proveedor</th>
                <th>Año</th>
                <th>Hs Contratadas</th>
                <th>Negocio</th>
                <th>Interno</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($equipments as $equipment): ?>
                <tr onclick="window.location.href='../equipments/equipment_detail.php?id=<?php echo $equipment['id']; ?>'">

                    <td>
                        <?php echo $equipment['operation_name']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['equipment_type']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['brand']; ?>
                        <?php echo $equipment['model']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['provider_name']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['year']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['contracted_hours']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['business_name']; ?>
                    </td>

                    <td>
                        <?php echo $equipment['internal_number']; ?>
                    </td>

                    <td>
                        $
                        <?php echo number_format(
                            $equipment['monthly_cost'],
                            2,
                            ',',
                            '.'
                        ); ?>
                    </td>
                    <td onclick="event.stopPropagation();">
                        <a
                            href="../equipments/edit_equipment.php?id=<?php echo $equipment['id']; ?>"
                            class="btn btn-sm btn-outline-warning">
                            Editar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>