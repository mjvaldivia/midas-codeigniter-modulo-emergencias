<?php
/**
 * User: claudio
 * Date: 14-08-15
 * Time: 01:10 PM
 */
?>

<form id="frmIngresoAlarma" action="<?= site_url("alarma/ingresoPaso2") ?>" method="POST" class="form-horizontal">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Datos de la alarma</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-md-4">Nombre del informante (*):</label>
                <div class="col-md-6">
                    <input name="iNombreInformante" type="text" class="form-control" placeholder="Nombre del informante"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Teléfono del informante:</label>
                <div class="col-md-6">
                    <input name="iTelefonoInformante" type="text" class="form-control" placeholder="Teléfono del informante"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Nombre de la emergencia (*):</label>
                <div class="col-md-6">
                    <input name="iNombreEmergencia" type="text" class="form-control" placeholder="Nombre de la emergencia"/>
                </div>
            </div>
            <div class="form-group">
                <label for="iTiposEmergencias" class="control-label col-md-4">Tipo de la emergencia (*):</label>
                <div class="col-md-6">
                    <select name="iTiposEmergencias" id="iTiposEmergencias" class="form-control"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Lugar o dirección de la emergencia (*):</label>
                <div class="col-md-6">
                    <textarea name="iLugarEmergencia" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Observación:</label>
                <div class="col-md-6">
                    <textarea name="iObservacion" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Fecha/Hora de la emergencia:</label>
                <div class="col-md-6">
                    <div class="input-group" id="fechaEmergencia" type="datetime">
                        <input class="form-control" placeholder="Fecha / Hora" name="fechaEmergencia">
                        <div class="input-group-addon" style="cursor: pointer">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Fecha/Hora de recepción:</label>
                <div class="col-md-6">
                    <div class="input-group" id="fechaRecepcion" type="datetime">
                        <input class="form-control" placeholder="Fecha / Hora" name="fechaRecepcion">
                        <div class="input-group-addon" style="cursor: pointer">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Comuna(s) afectada(s):</label>
                <div class="col-md-6">
                    <select name="iComunas" id="iComunas" class="form-control" multiple>
                    </select>
                </div>
            </div>

            <div id="botonera" class="col-md-10">
                <div class="pull-right">
                    <button id="btnSiguiente" type="submit" class="btn btn-primary">Siguiente</button>
                    <button type="button" class="btn btn-default">Cancelar</button>
                </div>
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

<?= loadJS("assets/js/alarmas.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Alarma.inicioIngreso();
    });
</script>