<div class="equipment-top-grid">

            <div class="detail-card">

                <h3 class="card-title">
                    Información General
                </h3>

                <div class="info-card-content">

                    <div>

                        <div class="info-row">
                            <span>Interno</span>
                            <strong><?php echo $equipment['internal_number']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Tipo</span>
                            <strong><?php echo $equipment['equipment_type']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Marca</span>
                            <strong><?php echo $equipment['brand']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Modelo</span>
                            <strong><?php echo $equipment['model']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>Año</span>
                            <strong><?php echo $equipment['year']; ?></strong>
                        </div>

                        <div class="info-row">
                            <span>N° Serie</span>
                            <strong><?php echo $equipment['serial_number']; ?></strong>
                        </div>

                    </div>

                    <div class="equipment-image-box">

                        <?php if (!empty($equipment['image'])): ?>

                            <img
                                src="/surdev/assets/uploads/equipments/<?php echo $equipment['image']; ?>"
                                alt="Equipo">

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <div class="detail-card">

                <h3 class="card-title">
                    Ubicación Actual
                </h3>

                <div class="location-row">
                    <span>Operación</span>
                    <strong><?php echo $equipment['operation_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Site</span>
                    <strong><?php echo $equipment['site_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Negocio</span>
                    <strong><?php echo $equipment['business_name']; ?></strong>
                </div>

                <div class="location-row">
                    <span>Proveedor</span>
                    <strong><?php echo $equipment['provider_name']; ?></strong>
                </div>

                <div class="mt-4">

                    <button
                        class="btn btn-outline-primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#changeLocationModal">
                        Cambiar Operación / Site
                    </button>

                </div>

            </div>

            <div class="detail-card">

                <h3 class="card-title">
                    Horas y Mantenimiento
                </h3>

                <div class="maintenance-content">

                    <div class="maintenance-gauge">

                        <div class="progress-ring" style=" background:conic-gradient(
                                <?php echo $color_grafico; ?> <?php echo $porcentaje; ?>%,
                                #e5e7eb <?php echo $porcentaje; ?>%
                            )" ;>

                            <div class="progress-inner">
                                <?php echo round($porcentaje); ?>%
                            </div>

                        </div>

                    </div>

                    <div class="maintenance-data">

                        <div class="location-row">
                            <span>Ciclo Preventivo</span>
                            <strong>
                                <?php echo $intervalo; ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Horometro actual</span>
                            <strong>
                                <?php echo number_format($horometro_actual, 0, ',', '.'); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Horas restantes</span>
                            <strong>
                                <?php echo $horas_restantes; ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Último mantenimiento</span>
                            <strong>
                                <?php echo number_format(
                                    $ultimo_mantenimiento_hs,
                                    0,
                                    ',',
                                    '.'
                                ); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Próximo mantenimiento</span>
                            <strong>
                                <?php echo number_format(
                                    $proximo_mantenimiento,
                                    0,
                                    ',',
                                    '.'
                                ); ?> hs
                            </strong>
                        </div>

                        <div class="location-row">
                            <span>Estado</span>

                            <strong class="maintenance-ok">
                                <?php echo $estado_mantenimiento; ?>
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>