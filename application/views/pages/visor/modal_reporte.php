
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
            <div id='dvMap' style="height: 350px; overflow-y: auto; background-color: gray;" class="col-md-4">

            </div>
            
            <input type="hidden" id='eme_ia_id' name="eme_ia_id" value='{id}'>
        </div>
        <div class="col-md-12">
            <div class="col-md-4 text-center text-danger">Ajuste esta vista previa del mapa que aparecerá en el reporte</div>
        </div>

    </div>
</div>

