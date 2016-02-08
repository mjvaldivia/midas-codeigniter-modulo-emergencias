<div class="col-lg-12">
    <div class="row">
        
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <h4><small><i class="fa fa-info-circle"></i> Información de la capa</small></h4>
                    <div class="tile dark-blue">
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>TIPO:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $nombre_tipo ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>CAPA:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $nombre_capa ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>SUB-CAPA:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $nombre_subcapa ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <h4>
                        <small><i class="fa fa-list"></i> Propiedades de la capa</small>
                    </h4>
                    <div class="tile blue">
                        <?php  echo visorInformacion($informacion); ?>
                    </div>
                </div>
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