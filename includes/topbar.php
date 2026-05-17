<div class="topbar">

    <div>
        <h4>
            <?php echo $page_title; ?>
        </h4>
    </div>

    <div class="user-info">

        <div class="avatar">
            <?php echo strtoupper(substr($_SESSION['user'],0,1)); ?>
        </div>

        <div>
            <strong>
                <?php echo $_SESSION['user']; ?>
            </strong>

            <p>
                <?php echo $_SESSION['rol']; ?>
            </p>
        </div>

    </div>

</div>