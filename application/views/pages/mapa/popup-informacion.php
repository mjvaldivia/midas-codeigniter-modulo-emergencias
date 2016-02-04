<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            

            <?php if($nombre_subcapa!="") { ?>
            <div class="col-lg-6">
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
            <?php } ?>

            <?php if($nombre_subcapa != "") { ?>
            <div class="col-lg-6">
            <?php  echo visorInformacion($informacion); ?>
            </div>
            <?php } else { ?>
            <?php echo visorEdicionElemento($tipo, $informacion, $color, $img); ?>
            <?php } ?>

        </div>
        <div class="col-lg-12 top-spaced">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4><i class="fa fa-home"></i> Instalaciones </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        
                         
                        <?php  echo visorElementoInstalaciones($lista_marcadores); ?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>