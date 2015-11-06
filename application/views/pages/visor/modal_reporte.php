
<?= loadJS("assets/lib/html2canvas/build/html2canvas.js") ?>

<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/MapReport.js") ?>
<script type="text/javascript">
          $(document).ready(function () {
        
        MapReport.LoadMap();
    });
     
</script>

<style>
    .ui-autocomplete {
    z-index: 5000;
}
</style>
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

            <input type="hidden" id='eme_ia_id' name="eme_ia_id" value='{id}'>
            <div class="col-md-7">
                <ul id="ul-tabs" class="nav nav-tabs">
                    <li class='active'><a href="#tab1" data-toggle="tab">Envío de reporte por e-mail</a></li>

                </ul>
                <div id="tab-content" class="tab-content">
                    <div class='tab-pane active' id='tab1' style='overflow:hidden;'>
                        <div class="col-xs-12">
                            <form class="form-horizontal">
                                <div  class='form-group'>
                                    <label class="col-xs-12">Seleccione destinatarios</label>
                                    <div class="col-xs-12">
                                        <textarea  class="form-control" id="tokenfield"  placeholder="escriba aquí su destinatario...">test1@cosof.cl,test2@cosof.cl</textarea>
                                    </div>

                                </div>
                            </form>
                        </div >
                        <div class="col-xs-12"><button onclick="MapReport.cloneMap();" class="btn btn-xs btn-warning" ><i class="fa fa-download"></i>Descargar Reporte</button></div>
                    </div>

                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="col-md-4 text-center text-danger">Ajuste esta vista previa del mapa que aparecerá en el reporte</div>
        </div>

    </div>
</div>

<div style="width: 0px; height: 0px; position: absolute; margin-top: 100px;">
    <div id='clon' style="width: 1024px; height: 768px;">

    </div>

</div>



