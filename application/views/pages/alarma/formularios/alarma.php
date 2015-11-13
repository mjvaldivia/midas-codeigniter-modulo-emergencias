<div class="col-xs-12">
<form  class="form-horizontal"  name='frmIngresoAlarma' id='frmIngresoAlarma' >
    <input type="hidden" name="ala_ia_id" id="ala_ia_id" value="<?= $ala_ia_id ?>" />
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title"><h4>Datos de la alarma</h4></div>
        </div>
        <div class="portlet-body">
            <div class="col-md-12">
                <div class="col-md-4 well">
                    <input type="hidden" id="geozone" name="geozone" /> 
                    <h4>Lugar de referencia</h4>
                    <div id="map" class="col-md-12" style="height: 400px !important;"></div>
                    <div id="coords" class="col-md-12"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br>
                            <label>Lon:</label>
                            <input id="ins_c_coordenada_e" name="ins_c_coordenada_e" type="number" value="<?= $lon ?>"
                                   class="form-control required" onchange="set_marker_by_inputs()" placeholder="longitud (e)" onkeyup="set_marker_by_inputs()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <br>
                            <label>Lat:</label>
                            <input id="ins_c_coordenada_n" name="ins_c_coordenada_n" type="number" value="<?= $lat ?>"
                                   class="form-control required" onchange="set_marker_by_inputs()" placeholder="latitud (n)" onkeyup="set_marker_by_inputs()">
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nombre del informante (*):</label>
                        <div class="col-md-6">
                            <input name="iNombreInformante" id="iNombreInformante" type="text" value="<?= $nombre_informante ?>" class="form-control required" placeholder="Nombre del informante"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Teléfono del informante:</label>
                        <div class="col-md-6">
                            <input name="iTelefonoInformante" id="iTelefonoInformante" type="text" value="<?= $telefono ?>" class="form-control" placeholder="Teléfono del informante"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Nombre de la emergencia (*):</label>
                        <div class="col-md-6">
                            <input name="iNombreEmergencia" id="iNombreEmergencia" type="text" value="<?= $nombre_emergencia ?>" class="form-control required" placeholder="Nombre de la emergencia"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iTiposEmergencias" class="control-label col-md-4">Tipo de la emergencia (*):</label>
                        <div class="col-md-6">
                            <select id="iTiposEmergencias" name='iTiposEmergencias' class="form-control required" placeholder='Tipo de la emergencia'></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iLugarEmergencia" class="control-label col-md-4 ">Lugar de la Emergencia (*)</label>
                        <div class="col-md-6">
                            <input type="text" name="iLugarEmergencia" id="iLugarEmergencia" value="<?= $lugar ?>" class="form-control required"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-4">Observación:</label>
                        <div class="col-md-6">
                            <textarea name="iObservacion" id="iObservacion" class="form-control"><?= $observacion ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Fecha/Hora de la emergencia:</label>
                        <div class="col-md-3">
                            <div class="input-group" id="divfechaEmergencia" type="datetime">
                                <input type="text" class="form-control" placeholder="Fecha / Hora" value="<?= $fecha_emergencia ?>" id="fechaEmergencia" name="fechaEmergencia">
                                <div class="input-group-addon" style="cursor: pointer">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Fecha/Hora de recepción (*):</label>
                        <div class="col-md-3">
                            <div class="input-group" id="divfechaRecepcion" type="datetime">
                                <input type="text" class="form-control required" placeholder="Fecha / Hora Recepcion" value="<?= ($id!==null)?$fecha_recepcion:date('d-m-Y H:i') ?>" id="fechaRecepcion" name="fechaRecepcion" >
                                <div  class="input-group-addon" style="cursor: pointer">
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

                    <div id="botonera" class="col-md-10">
                        <div class="pull-right">
                            <?php if($es_CRE==1 && $id==null) { ?> 
                                <button type="button" id="btnSiguiente" class="btn btn-green btn-square" onclick="Alarma.guardarForm(1);">Aceptar y continuar con la activación</button>
                            <?php } ?>
                            <button type="button" id="btnSiguiente" class="btn btn-green btn-square" onclick="Alarma.guardarForm(0);">Aceptar</button>
                           
                            <button type="button" class="btn btn-default btn-square" onclick="Alarma.cancelarEdicion();" style="display:none" id="btnCancelarEdicion">Cancelar</button>
                        </div>
                    </div>


                </div>

            </div>





        </div>
    </div>
</form>
</div>
