<div class="topbar">

    <div>
        <h4>
            <?php echo $page_title; ?>
        </h4>
    </div>

    <div class="user-info">

        <div class="avatar">
            <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U',0,1)); ?>
        </div>

        <div>
            <strong>
                <?php echo htmlspecialchars(($_SESSION['user_name'] ?? 'Usuario') . ' ' . ($_SESSION['user_lastname'] ?? '')); ?>
            </strong>

            <p>
                <?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Sin rol'); ?>
            </p>
        </div>

    </div>

</div>