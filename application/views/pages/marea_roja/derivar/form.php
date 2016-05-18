<div class="row text-left">
    <form name="form_resultado" id="form-resultado">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="numero_de_muestra" class="control-label">N° de muestra (*):</label>
                                    <input value="<?php echo $propiedades["numero_de_muestra"]; ?>" disabled class="form-control" name="numero_de_muestra" id="numero_de_muestra">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="laboratorio" class="control-label">Laboratorio (*):</label>
                                    <input value="<?php echo $propiedades["laboratorio"]; ?>" disabled class="form-control" name="laboratorio" id="laboratorio">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="fecha" class="control-label">Fecha de toma de muestra(*):</label>
                                    <input value="<?php echo $propiedades["fecha"]; ?>" disabled class="form-control" name="fecha" id="fecha">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group clearfix">
                                    <label for="recurso" class="control-label">Recurso (*):</label>
                                    <input value="<?php echo $propiedades["recurso"]; ?>" disabled class="form-control" name="recurso" id="recurso">
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-6">
                        
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="resultado" class="control-label">Derivar a laboratorio(*):</label>
                                        <?php echo formSelectLaboratorio("laboratorio", array("class" => "form-control"), ""); ?>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                
                            </div>
                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="fuente_de_la_informacion" class="control-label">Fuente de la información:</label>
                            <input value="<?php echo $propiedades["fuente_de_la_informacion"]; ?>" disabled class="form-control" name="fuente_de_la_informacion" id="fuente_de_la_informacion">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="origen" class="control-label">Origen (*):</label>
                            <input value="<?php echo $propiedades["origen"]; ?>" disabled class="form-control" name="origen" id="origen">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="region" class="control-label">Región (*):</label>
                            <input value="<?php echo nombreRegion($propiedades["region"]); ?>" disabled class="form-control" name="region" id="region">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="comuna" class="control-label">Comuna:</label>
                            <input value="<?php echo nombreComuna($propiedades["comuna"]); ?>" disabled class="form-control" name="comuna" id="comuna">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>    
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="profundidad" class="control-label">Profundidad:</label>
                            <input value="<?php echo $propiedades["profundidad"]; ?>" disabled class="form-control" name="profundidad" id="profundidad">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="temperatura" class="control-label">Temperatura:</label>
                            <input value="<?php echo $propiedades["temperatura"]; ?>" disabled class="form-control" name="temperatura" id="temperatura">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group clearfix">
                            <label for="vp" class="control-label">N° VP:</label>
                            <input value="<?php echo $propiedades["vp"]; ?>" disabled class="form-control" name="vp" id="vp">
                            <span class="help-block hidden"></span>
                        </div>
                    </div>

                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group clearfix">
                            <label for="observaciones" class="control-label ">Observaciones:</label>
                            <textarea name="observaciones" disabled class="form-control" id="observaciones"><?php echo $propiedades["observaciones"]; ?></textarea>
                            <span class="help-block hidden"></span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="col-md-12">
                        <div id="form_error" class="alert alert-danger hidden">
                            <strong> Existen problemas con los datos ingresados </strong> <br>
                            Revise y corrija los campos iluminados en rojo.
                        </div>
                        </div>
                    </div>
                </div> 
                
            </div>
        </div>
    </div>
    </form>
</div>