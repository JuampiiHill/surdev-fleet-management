<ul class="nav nav-tabs mb-4" id="equipmentTabs" role="tablist">

                    <li class="nav-item">

                        <button
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#usage-tab">
                            Uso del Equipo
                        </button>

                    </li>

                    <li class="nav-item">

                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#or-tab">
                            Órdenes de Reparación
                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ot-tab">
                            Órdenes de Trabajo
                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#preventive-tab">
                            Preventivos
                        </button>

                    </li>

                    <li class="nav-item">

                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#downtime-tab">
                            Indisponibilidades
                        </button>

                    </li>

                    <li class="nav-item">

                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#costs-tab">
                            Costos
                        </button>

                    </li>

                </ul>

<div class="tab-content">

<?php include 'tabs_contents/usage_tab.php'; ?>
<?php include 'tabs_contents/repair_orders_tab.php'; ?>
<?php include 'tabs_contents/work_orders_tab.php'; ?>
<?php include 'tabs_contents/preventives_tab.php'; ?>
<?php include 'tabs_contents/downtimes_tab.php'; ?>
<?php include 'tabs_contents/costs_tab.php'; ?>

</div>