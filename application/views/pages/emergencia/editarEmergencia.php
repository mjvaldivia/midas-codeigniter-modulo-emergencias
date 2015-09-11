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
  <li class="active">Editar emergencia</li>
</ol>
<form  class="form-horizontal"  name='frmEditarEmergencia' id='frmEditarEmergencia'>
    <input type="hidden" id="ala_ia_id" name="ala_ia_id">
    <input type="hidden" id="eme_ia_id" name="eme_ia_id" value={eme_ia_id}>
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
            
            <div class="form-group">
                <label class="control-label col-md-4">¿Dispone de recursos suficientes para controlar la emergencia?:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_recursos" id="eme_c_recursos" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Está en riesgo la seguridad de nuestro personal?:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_riesgo" id="eme_c_riesgo" class="form-control"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-4">Impacto a las personas. Número de heridos:</label>
                <div class="col-md-6">
                    <input name="eme_c_heridos" id="eme_c_heridos" type="text" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Impacto a las personas. Número de fallecidos:</label>
                <div class="col-md-6">
                    <input name="eme_c_fallecidos" id="eme_c_fallecidos" type="text" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">¿En qué ha sido superada su capacidad para una respuesta eficiente y efectiva?:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_capacidad" id="eme_c_capacidad" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Descripción del evento:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_descripcion" id="eme_c_descripcion" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Acciones:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_acciones" id="eme_c_acciones" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Información adicional:</label>
                <div class="col-md-6">
                    <textarea name="eme_c_informacion_adicional" id="eme_c_informacion_adicional" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-offset-1 col-md-3 control-label">Antecedentes documentales</label>
                <div class="col-md-5">
                    <input id="iDocMaterial" name="iDocMaterial[]" class="form-control" type="file" multiple data-show-preview="false"></input>
                </div>
            </div>
            <div class="form-group ">

        

                    
                    <div class="col-md-offset-4 col-md-5"> 
                        <table id="tabla_doc" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <td>Nombre Archivo</td>
                                <td>Autor</td>
                                <td>Fecha</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>   
                    </div>
                   
                </div>
            
            
            <div id="botonera" class="col-md-10">
                    <button type="button" id="btnSiguiente" class="btn btn-primary pull-right" onclick="Emergencia.guardarForm();">Guardar</button>
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

<?= loadJS("assets/js/editarEmergencia.js") ?>

<?= loadCSS("assets/lib/bootstrap-fileinput/css/fileinput.min.css") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput.min.js") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Emergencia.inicio();
    });

</script>