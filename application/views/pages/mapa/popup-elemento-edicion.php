<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <?php echo visorEdicionElemento($tipo, $informacion, $color, $img); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#instalaciones" aria-controls="instalaciones" role="tab" data-toggle="tab">
                        <i class="fa fa-map-marker"></i> Marcadores <div class="badge"><?php echo count($lista_marcadores) ?></div>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#zonas" aria-controls="zonas" role="tab" data-toggle="tab">
                        <i class="fa fa-object-group"></i> Zonas <div class="badge"><?php echo count($lista_formas) ?></div>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#coordenadas" aria-controls="zonas" role="tab" data-toggle="tab">
                        <i class="fa fa-map"></i> Coordenadas del elemento
                    </a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="instalaciones">
                    <div class="top-spaced">
                        <?php echo visorElementoInstalaciones($lista_marcadores); ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="zonas">
                    <?php echo visorElementoFormas($lista_formas); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="coordenadas">
                    <?php echo visorElementoCoordenadas($tipo, $coordenadas); ?>
                </div>
            </div>

            
        </div>
    </div>
</div>
<div class="clearfix"></div>