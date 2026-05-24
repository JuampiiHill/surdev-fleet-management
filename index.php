<?php include 'includes/header.php'; ?>

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

<section class="container hero-section">

    <div class="row align-items-center">

        <div class="col-md-6 hero-text">

            <h1 class="display-4 fw-bold">
                Gestión inteligente de flota industrial
            </h1>

            <p class="lead mt-4">
                Centralizá equipos, costos,
                mantenimientos y operaciones
                en una única plataforma.
            </p>

            <button 
                class="btn btn-primary btn-lg mt-3"
                data-bs-toggle="modal"
                data-bs-target="#loginModal"
            >
                Iniciar sesión
            </button>

        </div>

        <div class="col-md-6 d-flex justify-content-center">

            <div class="hero-image-wrapper">

                <img 
                    src="assets/img/forklift.png"
                    class="hero-image"
                    alt="Sistema de gestión industrial"
                >

            </div>

        </div>

    </div>

</section>

<!-- LOGIN MODAL -->

<div class="modal fade" id="loginModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-md">

        <div class="modal-content login-modal">

            <div class="modal-header border-0">

                <div>

                    <h4 class="fw-bold mb-1">
                        Bienvenido
                    </h4>

                    <p class="text-muted mb-0">
                        Inicia sesión para continuar
                    </p>

                </div>

                <button 
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body pt-0">

                <form action="controllers/auth/validate_login.php" method="POST">

                    <div class="mb-3">

                        <label class="form-label login-label">
                            Email
                        </label>

                        <input 
                            type="email"
                            name="email"
                            class="form-control login-input"
                            placeholder="correo@empresa.com"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label login-label">
                            Contraseña
                        </label>

                        <input 
                            type="password"
                            name="password"
                            class="form-control login-input"
                            placeholder="••••••••"
                            required
                        >

                    </div>

                    <button class="btn login-btn w-100">
                        Ingresar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>