<div class="filters">
            <div>

                <label class="filter-label">
                    Operación
                </label>

                <select class="form-select">

                    <option value="">
                        Todas las operaciones
                    </option>

                    <?php foreach($operations as $op): ?>

                        <option value="<?php echo $op['id']; ?>">
                            <?php echo $op['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Negocio
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los negocios
                    </option>

                    <?php foreach($business as $b): ?>

                        <option value="<?php echo $b['id']; ?>">
                            <?php echo $b['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Site
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los sites
                    </option>

                    <?php foreach($sites as $site): ?>

                        <option value="<?php echo $site['id']; ?>">
                            <?php echo $site['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Proveedor
                </label>

                <select class="form-select">

                    <option value="">
                        Todos los proveedores
                    </option>

                    <?php foreach($providers as $p): ?>

                        <option value="<?php echo $p['id']; ?>">
                            <?php echo $p['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Estado
                </label>

                <select class="form-select">

                    <option value="">
                        Todos
                    </option>

                    <?php foreach($statuses as $status): ?>

                        <option value="<?php echo $status['id']; ?>">
                            <?php echo $status['name']; ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div>

                <label class="filter-label">
                    Buscar
                </label>

                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar equipo..."
                >
            </div>
        </div>