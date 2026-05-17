<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div class="sidebar">

    <div class="logo">
        <h4>FLOTA INDUSTRIAL</h4>
    </div>

    <ul class="menu">

        <li>
            <a href="../dashboard/dashboard.php"
            class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>
        </li>

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
                <i class="bi bi-tools"></i>
                Proveedores
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-tools"></i>
                Ordenes
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-tools"></i>
                Reportes
            </a>
        </li>

        <li>
            <a href="#">
                <i class="bi bi-tools"></i>
                Configuraciones
            </a>
        </li>
    </ul>

</div>