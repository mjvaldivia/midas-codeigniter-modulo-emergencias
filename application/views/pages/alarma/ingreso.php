<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>
<div class="clearfix"></div>
<ol class="breadcrumb">
    <li><a href="<?= site_url() ?>">Dashboard</a></li>  
    <li class="active">Gestión de alarmas</li>
</ol>

<ul id="ul-tabs" class="nav nav-tabs">
    <li class='active'><a href="#tab1" data-toggle="tab">Nueva</a></li>
    <li><a href="#tab2" data-toggle="tab">Listado</a></li>
</ul>
<div id="tab-content" class="tab-content">
    <div class='tab-pane active' id='tab1' style='overflow:hidden;'>
        <div id='div_tab_1' class='col-xs-12'>
            <br>
            <form  class="form-horizontal"  name='frmIngresoAlarma' id='frmIngresoAlarma' >

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la alarma</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-lg-4 well">
                                <input type="hidden" id="geozone" name="geozone" /> 
                                <h4>Lugar de referencia</h4>
                                <div id="map" class="col-md-12" style="height: 400px !important;"></div>
                                <div id="coords" class="col-md-12"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br>
                                        <label>Lon:</label>
                                        <input id="ins_c_coordenada_e" name="ins_c_coordenada_e" type="number"
                                               class="form-control required" onchange="set_marker_by_inputs()" placeholder="longitud (e)" onkeyup="set_marker_by_inputs()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <br>
                                        <label>Lat:</label>
                                        <input id="ins_c_coordenada_n" name="ins_c_coordenada_n" type="number"
                                               class="form-control required" onchange="set_marker_by_inputs()" placeholder="latitud (n)" onkeyup="set_marker_by_inputs()">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nombre del informante (*):</label>
                                    <div class="col-md-6">
                                        <input name="iNombreInformante" id="iNombreInformante" type="text" class="form-control required" placeholder="Nombre del informante"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Teléfono del informante:</label>
                                    <div class="col-md-6">
                                        <input name="iTelefonoInformante" id="iTelefonoInformante" type="text" class="form-control" placeholder="Teléfono del informante"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nombre de la emergencia (*):</label>
                                    <div class="col-md-6">
                                        <input name="iNombreEmergencia" id="iNombreEmergencia" type="text" class="form-control required" placeholder="Nombre de la emergencia"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="iTiposEmergencias" class="control-label col-md-3">Tipo de la emergencia (*):</label>
                                    <div class="col-md-6">
                                        <select name="iTiposEmergencias" id="iTiposEmergencias" class="form-control required" placeholder='Tipo de la emergencia'></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="iLugarEmergencia" class="control-label col-md-3 ">Lugar de la Emergencia (*)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="iLugarEmergencia" id="iLugarEmergencia" class="form-control required"/>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3">Observación:</label>
                                    <div class="col-md-6">
                                        <textarea name="iObservacion" id="iObservacion" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Fecha/Hora de la emergencia:</label>
                                    <div class="col-md-3">
                                        <div class="input-group" id="fechaEmergencia" type="datetime">
                                            <input type="text" class="form-control" placeholder="Fecha / Hora" id="fechaEmergencia" name="fechaEmergencia">
                                            <div class="input-group-addon" style="cursor: pointer">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Fecha/Hora de recepción (*):</label>
                                    <div class="col-md-3">
                                        <div class="input-group" id="fechaRecepcion" type="datetime">
                                            <input type="text" class="form-control required" placeholder="Fecha / Hora Recepcion" id="fechaRecepcion" name="fechaRecepcion" value="<?= date('d-m-Y H:i') ?>">
                                            <div  class="input-group-addon" style="cursor: pointer">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Comuna(s) afectada(s) (*):</label>
                                    <div class="col-md-6">
                                        <select name="iComunas[]" id="iComunas" class="form-control required" multiple placeholder='Comunas'>
                                        </select>
                                    </div>
                                </div>

                                <div id="botonera" class="col-md-10">
                                    <div class="pull-right">
                                        <button type="button" id="btnSiguiente" class="btn btn-primary" onclick="Alarma.guardarForm();">Aceptar</button>
                                        <button type="button" class="btn btn-default">Cancelar</button>
                                    </div>
                                </div>


                            </div>

                        </div>





                    </div>
                </div>
            </form>

        </div>

    </div>
    <div class='tab-pane' id='tab2' style='overflow:hidden;'>
        <div id='div_tab_2' class='col-xs-12'>

        </div>

    </div>
</div> 


<?= loadCSS("assets/lib/picklist/picklist.css") ?>
<?= loadJS("assets/lib/picklist/picklist.js") ?>

<?= loadJS("assets/js/moment.min.js") ?>
<?= loadCSS("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
<?= loadJS("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>

<?= loadJS("assets/js/bootbox.min.js") ?>
<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/alarmas.js") ?>

<script type="text/javascript">
    $(document).ready(function () {
        Alarma.inicioIngreso();
        $('#div_tab_2').load(siteUrl+'alarma/listado');
    });
</script>