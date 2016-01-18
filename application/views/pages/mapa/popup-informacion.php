<div class="row">
    <div class="col-lg-4">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-info"></i> Información </h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="col-lg-12">
                    
                    <?php if($nombre_subcapa!="") { ?>
                    <div class="row">
                        <legend style="font-size: 12px; font-weight: bold; margin-bottom: 10px;"> Capa </legend>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">TIPO:</div>
                        <div class="col-lg-8"><?php echo $nombre_tipo ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">CAPA:</div>
                        <div class="col-lg-8"><?php echo $nombre_capa ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">SUB-CAPA:</div>
                        <div class="col-lg-8"><?php echo $nombre_subcapa ?></div>
                    </div>
                    <div class="top-spaced"></div>
                    <?php } ?>
                    
                    <div class="row">
                        <legend style="font-size: 12px; font-weight: bold; margin-bottom: 10px;"> Datos del elemento </legend>
                    </div>
                    
                    <?php if($nombre_subcapa != "") { ?>
                    <?php  echo visorInformacion($informacion); ?>
                    <?php } else { ?>
                    <?php echo visorEdicionElemento($tipo, $informacion, $color, $img); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-home"></i> Instalaciónes </h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12" data-row="5">
                        <?php  echo visorPoligonoInstalaciones($lista_marcadores); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>