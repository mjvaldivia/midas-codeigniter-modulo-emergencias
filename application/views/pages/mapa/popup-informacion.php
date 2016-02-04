<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            
            <div class="row">
                <?php if($nombre_subcapa!="") { ?>
                <div class="col-lg-4">
                    <h4><small><i class="fa fa-info-circle"></i> Información de la capa</small></h4>
                    <div class="tile dark-blue">
                        <div class="row">
                            <div class="col-lg-4"><strong>TIPO:</strong></div>
                            <div class="col-lg-8"><?php echo $nombre_tipo ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><strong>CAPA:</strong></div>
                            <div class="col-lg-8"><?php echo $nombre_capa ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><strong>SUB-CAPA:</strong></div>
                            <div class="col-lg-8"><?php echo $nombre_subcapa ?></div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if($nombre_subcapa != "") { ?>
                <div class="col-lg-8">
                    <h4><small><i class="fa fa-list"></i> Propiedades de la capa</small></h4>
                    <div class="tile blue">
                    <?php  echo visorInformacion($informacion); ?>
                    </div>
                </div>
                <?php } else { ?>
                <?php echo visorEdicionElemento($tipo, $informacion, $color, $img); ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-12">

            <h4><small><i class="fa fa-home"></i> Instalaciones <small></h4>
    
            <div class="row">
                <?php  echo visorElementoInstalaciones($lista_marcadores); ?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>