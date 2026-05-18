<div class="modal fade" id="createProviderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Nuevo Proveedor
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="../../modules/store_provider.php" method="POST">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Nombre proveedor
                        </label>

                        <input type="text"
                               name="provider"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>