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
