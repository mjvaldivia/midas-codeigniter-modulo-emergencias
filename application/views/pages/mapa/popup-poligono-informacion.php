

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
                    <div class="row">
                        <legend style="font-size: 12px; font-weight: bold; margin-bottom: 10px;"> Datos de poligono </legend>
                    </div>
                    <?php echo visorInformacion($informacion); ?>
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
                        <?php echo visorPoligonoInstalaciones($lista_marcadores); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>