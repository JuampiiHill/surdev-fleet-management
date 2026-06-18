<?php include 'partials/layout/header.php'; ?>

<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            SURDEV
        </a>

        <button 
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#loginModal"
        >
            Iniciar sesión
        </button>

    </div>
</nav>

<?php include 'partials/landing/hero.php'; ?>
<?php include 'partials/modals/login_modal.php'; ?>
<?php include 'partials/layout/footer.php'; ?>