<?php include 'includes/header.php'; ?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
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

<section class="container py-5">

    <div class="row align-items-center">

        <div class="col-md-6">

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

        <div class="col-md-6 text-center">

            <img 
                src="assets/img/forklift.png"
                class="img-fluid"
                width="450"
            >

        </div>

    </div>

</section>


<div class="modal fade" id="loginModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Iniciar sesión</h5>

                <button 
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>

            <div class="modal-body">

                <form action="controllers/auth/validate_login.php" method="POST">

                    <div class="mb-3">
                        <label>Email</label>

                        <input 
                            type="email"
                            name="email"
                            class="form-control"
                        >
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>

                        <input 
                            type="password"
                            name="password"
                            class="form-control"
                        >
                    </div>

                    <button class="btn btn-primary w-100">
                        Ingresar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>