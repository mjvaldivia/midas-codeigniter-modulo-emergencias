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

            <h4><small><i class="fa fa-home"></i> Instalaciones </small></h4>
    
            <div class="row">
                <?php  echo visorElementoInstalaciones($lista_marcadores); ?>
            </div>
        </div>
        
    </div>
</div>
<div class="clearfix"></div>