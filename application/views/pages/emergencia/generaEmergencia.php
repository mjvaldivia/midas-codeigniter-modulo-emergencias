<style>
    .fileinput-remove-button{
        display: none !important;
    }
    .fileinput-remove{
        display: none !important;
    }
</style>
<div class="clearfix"></div>
<ol class="breadcrumb">
    <li><a href="<?= site_url() ?>">Inicio</a></li>  
  <li class="active">Gestión de Emergencia</li>
</ol>
<form  class="form-horizontal"  name='frmIngresoEmergencia' id='frmIngresoEmergencia'>
    <input name="ala_ia_id" id="ala_ia_id"  value={ala_ia_id} type="hidden" />
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Datos de la emergencia</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-md-4">Nombre del informante (*):</label>
                <div class="col-md-6">
                    <input name="iNombreInformante" id="iNombreInformante" type="text" class="form-control required" placeholder="Nombre del informante"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Teléfono del informante:</label>
                <div class="col-md-6">
                    <input name="iTelefonoInformante" id="iTelefonoInformante" type="text" class="form-control" placeholder="Teléfono del informante"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Nombre de la emergencia (*):</label>
                <div class="col-md-6">
                    <input name="iNombreEmergencia" id="iNombreEmergencia" type="text" class="form-control required" placeholder="Nombre de la emergencia"/>
                </div>
            </div>
            <div class="form-group">
                <label for="iTiposEmergencias" class="control-label col-md-4">Tipo de la emergencia (*):</label>
                <div class="col-md-6">
                    <select name="iTiposEmergencias" id="iTiposEmergencias" class="form-control required" placeholder='Tipo de la emergencia'></select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Lugar o dirección de la emergencia (*):</label>
                <div class="col-md-6">
                    <textarea name="iLugarEmergencia" id="iLugarEmergencia" class="form-control required" placeholder="Lugar o dirección de la emergencia"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Observación:</label>
                <div class="col-md-6">
                    <textarea name="iObservacion" id="iObservacion" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Fecha/Hora de la emergencia:</label>
                <div class="col-md-2">
                    <div class="input-group" id="divfechaEmergencia" type="datetime">
                        <input class="form-control" placeholder="Fecha / Hora" name="fechaEmergencia" id="fechaEmergencia">
                        <div class="input-group-addon" style="cursor: pointer">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Fecha/Hora de recepción:</label>
                <div class="col-md-2">
                    <div class="input-group" id="divfechaRecepcion" type="datetime">
                        <input class="form-control" placeholder="Fecha / Hora" name="fechaRecepcion" id="fechaRecepcion">
                        <div class="input-group-addon" style="cursor: pointer">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Comuna(s) afectada(s) (*):</label>
                <div class="col-md-6">
                    <select name="iComunas[]" id="iComunas" class="form-control required" multiple placeholder='Comunas'>
                    </select>
                </div>
            </div>
            
            <div id="botonera" class="col-md-12">

                    <button type="button" id="btnSiguiente" class="btn btn-primary pull-right" onclick="Emergencia.guardarForm();">Activar y Generar Emergencia</button>
                    <button type="button" class="btn btn-danger pull-left" onclick="Emergencia.rechazar();">Rechazar Emergencia</button>

            </div>
        </div>
    </div>
</form>

<?= loadCSS("assets/lib/picklist/picklist.css") ?>
<?= loadJS("assets/lib/picklist/picklist.js") ?>

<?= loadJS("assets/js/moment.min.js") ?>
<?= loadCSS("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
<?= loadJS("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>

<?= loadCSS("assets/lib/jquery-ui-1.11.4/jquery-ui.css") ?>

<?= loadJS("assets/js/bootbox.min.js") ?>

<?= loadJS("assets/js/emergencia.js") ?>

<?= loadCSS("assets/lib/bootstrap-fileinput/css/fileinput.min.css") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput.min.js") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Emergencia.inicioIngreso();
    });
</script>