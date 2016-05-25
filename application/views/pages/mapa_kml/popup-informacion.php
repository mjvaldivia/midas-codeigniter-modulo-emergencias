<div class="col-lg-12">
    <div class="row">
        <input type="hidden" name="archivo_id" id="archivo_id" value="<?php echo $id; ?>" />
        <input type="hidden" name="archivo_hash" id="archivo_hash" value="<?php echo $hash; ?>" />

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        <div class="pull-left">
                            <small><i class="fa fa-info-circle"></i> Información del archivo cargado</small>
                        </div>


                        <div class="clearfix"></div>
                    </h4>
                    <div class="tile dark-blue">
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>NOMBRE:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $nombre ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>ARCHIVO:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $archivo ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>TIPO:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $tipo ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#instalaciones" aria-controls="instalaciones" role="tab" data-toggle="tab">
                        <i class="fa fa-map-marker"></i> Marcadores <div class="badge"></div>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#zonas" aria-controls="zonas" role="tab" data-toggle="tab">
                        <i class="fa fa-object-group"></i> Zonas <div class="badge"></div>
                    </a>
                </li>

            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="instalaciones">
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="zonas">
                   
                </div>
                <div role="tabpanel" class="tab-pane" id="coordenadas">
                   
                </div>
            </div>

            
        </div>
        
    </div>
</div>
<div class="clearfix"></div>

