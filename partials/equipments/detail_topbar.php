<div class="detail-topbar">

        <a
            href="../dashboard/dashboard.php"
            class="detail-back-link">
            <i class="bi bi-arrow-left"></i>
            Volver al listado
        </a>

        <div class="user-info">

            <div class="avatar">
                <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
            </div>

            <div>
                <strong>
                    <?php echo htmlspecialchars(($_SESSION['user_name'] ?? 'Usuario') . ' ' . ($_SESSION['user_lastname'] ?? '')); ?>
                </strong>

                <p class="mb-0">
                    <?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Sin rol'); ?>
                </p>
            </div>

        </div>

    </div>