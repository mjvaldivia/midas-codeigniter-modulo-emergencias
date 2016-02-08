<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <?php echo visorEdicionLugarEmergencia($tipo, $informacion, $color, $img); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#instalaciones" aria-controls="instalaciones" role="tab" data-toggle="tab">
                        <i class="fa fa-home"></i> Instalaciones <div class="badge"><?php echo count($lista_marcadores) ?></div>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#zonas" aria-controls="zonas" role="tab" data-toggle="tab">
                        <i class="fa fa-object-group"></i> Zonas <div class="badge"><?php echo count($lista_formas) ?></div>
                    </a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="instalaciones">
                    <?php echo visorElementoInstalaciones($lista_marcadores); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="zonas">
                    <?php echo visorElementoFormas($lista_formas); ?>
                </div>
            </div>

            
        </div>
    </div>
</div>
<div class="clearfix"></div>

