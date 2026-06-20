<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div class="sidebar">

    <div class="logo">
        <h4>FLOTA INDUSTRIAL</h4>
    </div>

    <ul class="menu">

        <li>
            <a href="../../views/dashboard/dashboard.php"
            class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>
        <!-- </li>

        <li>
            <a href="#">
                <i class="bi bi-truck"></i>
                Equipos
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-building"></i>
                Operaciones
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-geo-alt"></i>
                Sites
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-people"></i>
                Proveedores
            </a>
        </li> -->

        <li>
            <a href="../../views/repair_orders/repair_orders.php"
                class="<?php echo ($current_page == 'repair_orders.php') ? 'active' : ''; ?>">
                <i class="bi bi-clipboard-check"></i>
                    Órdenes
            </a>
        </li>

        <li>
            <a href="../../views/reports/reports.php"
            class="<?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>">
                <i class="bi bi-bar-chart"></i>
                Reportes
            </a>
        </li>

        <li>
            <a href="../../views/settings/settings.php"
                class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
            <i class="bi bi-gear"></i>
                Configuraciones
            </a>
        </li>
    </ul>

</div>