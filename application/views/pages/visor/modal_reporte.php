
<?= loadJS("assets/lib/html2canvas/build/html2canvas.js") ?>
<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/MapReport.js") ?>
<script type="text/javascript">
    $(document).ready(function () {
        MapReport.LoadMap();
    });
</script>


<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-file-pdf-o"></i>
            Ajustes del Reporte
        </h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div id='dvMap' style="height: 350px;" class="col-md-5">

            </div>
                            <div id='clon' style="height: 350px;" class="col-md-5">

            </div>
            <input type="hidden" id='eme_ia_id' name="eme_ia_id" value='{id}'>
            <div class="col-md-7">
                <ul id="ul-tabs" class="nav nav-tabs">
                    <li class='active'><a href="#tab1" data-toggle="tab">Generación de reporte</a></li>
                   
                </ul>
                <div id="tab-content" class="tab-content">
                    <div class='tab-pane active' id='tab1' style='overflow:hidden;'>
                        <div id='div_tab_1' class='col-xs-12'>
                            
                            <br>
                            <button onclick="MapReport.renderImage();" class="btn btn-xs btn-warning" ><i class="fa fa-download"></i>Descargar Reporte</button>
                            Seleccione destinatarios de email
                        </div>

                    </div>
                    
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="col-md-4 text-center text-danger">Ajuste esta vista previa del mapa que aparecerá en el reporte</div>
        </div>

    </div>
</div>

