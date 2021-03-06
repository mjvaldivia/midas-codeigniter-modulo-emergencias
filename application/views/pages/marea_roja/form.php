<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Marea roja </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="#"> Inicio </a></li>
                <li><i class="fa fa-list"></i> <a href="<?php echo base_url("marea_roja/index") ?>"> Marea roja</a></li>
                <li class="active"><i class="fa fa-bell"></i> Formulario </li>
                <li class="pull-right"><a href="<?php echo base_url("marea_roja/index") ?>"> <i class="fa fa-backward"></i> Volver </a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            
            <?php if($ingresado == "correcto") { ?>
            <div class="col-md-12">
                <div class="alert alert-success">
                    Se ha ingresado el caso correctamente
                </div>
            </div>
            <?php } ?>
            
            
            <form id="form" autocomplete="off" class="form-vertical" action="<?php echo base_url("marea_roja/guardar") ?>" method="post" role="form">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
            <div class="col-md-12">
                <legend>
                    Identificación Toma de Muestra <div class="pull-right"><small>(*) Campos obligatorios</small></div>
                </legend>
                <div class="portlet portlet-default">
                    <div class="portlet-body" style="overflow: visible">
                        <div class="row">
                        <div class="col-md-6">
                            
                            <div class="portlet portlet-default">
                                <div class="portlet-body"> 
                                    <?php echo formMapa("mapa"); ?>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <?php echo formCoordenadas("form_coordenadas", $latitud, $longitud, $propiedades); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                     
                        </div>
                        <div class="col-md-6">
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    
                                        <div class="col-xs-3">
                                            <div class="form-group clearfix">
                                                <label for="numero_de_muestra" class="control-label">N° de acta (*):</label>
                                                <input value="<?php echo $propiedades["numero_de_muestra"]; ?>" class="form-control" name="numero_de_muestra" id="numero_de_muestra">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <?php echo mareaRojaLaboratorioMuestra($id_laboratorio); ?>
                                        </div>
                              
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                            <div class="row">
                               
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="fecha" class="control-label">Fecha de toma de muestra(*):</label>
                                        <input value="<?php echo $propiedades["fecha"]; ?>" class="form-control datepicker-date" name="fecha" id="fecha">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="fuente_de_la_informacion" class="control-label">Fuente de la información:</label>
                                        <select name="fuente_de_la_informacion" id="fuente_de_la_informacion" class="form-control">
                                            <option value="">-- Seleccione un valor --</option>
                                            <option selected <?php // if($propiedades["fuente_de_la_informacion"] == "SEREMI Monitoreo") echo "selected"; ?> value="SEREMI Monitoreo"> SEREMI Monitoreo </option>
                                            <!--<option <?php if($propiedades["fuente_de_la_informacion"] == "PSMB") echo "selected"; ?> value="PSMB"> PSMB </option>
                                            <option <?php if($propiedades["fuente_de_la_informacion"] == "SEREMI Control de desembarco") echo "selected"; ?> value="SEREMI Control de desembarco">SEREMI Control de desembarco </option>
                                            <option <?php if($propiedades["fuente_de_la_informacion"] == "IFOP") echo "selected"; ?> value="IFOP"> IFOP </option>-->
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                             
                                <div class="col-xs-2">
                              
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="recurso" class="control-label">Recurso (*):</label>
                                        <select name="recurso" id="recurso" class="form-control">
                                            <option value="">-- Seleccione un valor --</option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "ALMEJAS") echo "selected"; ?> value="ALMEJAS"> ALMEJAS </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "ALMEJA JULIANA") echo "selected"; ?> value="ALMEJA JULIANA"> ALMEJA JULIANA </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHOCHAYUYO" || strtoupper($propiedades["recurso"]) == "COCHAYUYO") { echo "selected"; } ?> value="COCHAYUYO"> COCHAYUYO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHOLGAS") echo "selected"; ?> value="CHOLGAS"> CHOLGAS </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHORITO") echo "selected"; ?> value="CHORITO"> CHORITO </option>
                                           
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHORO") echo "selected"; ?> value="CHORO"> CHORO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHORO MALTÓN") echo "selected"; ?> value="CHORO MALTÓN"> CHORO MALTÓN </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CHORO ZAPATO") echo "selected"; ?> value="CHORO ZAPATO"> CHORO ZAPATO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "CULENGUE") echo "selected"; ?> value="CULENGUE"> CULENGUE </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "HUIRO") echo "selected"; ?> value="HUIRO"> HUIRO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "LAPA") echo "selected"; ?> value="LAPA"> LAPA </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "LOCO") echo "selected"; ?> value="LOCO"> LOCO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "LUCHE") echo "selected"; ?> value="LUCHE"> LUCHE </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "MACHAS") echo "selected"; ?> value="MACHAS"> MACHAS </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "NAVAJUELA") echo "selected"; ?> value="NAVAJUELA"> NAVAJUELA </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "OSTRA CH") echo "selected"; ?> value="OSTRA CH"> OSTRA CH </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "OSTRA JP") echo "selected"; ?> value="OSTRA JP"> OSTRA JP </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "OSTRAS") echo "selected"; ?> value="OSTRAS"> OSTRAS </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "PICOROCO") echo "selected"; ?> value="PICOROCO"> PICOROCO </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "PIURE") echo "selected"; ?> value="PIURE"> PIURE </option>
                                            <option <?php if(strtoupper($propiedades["recurso"]) == "TUMBAO") echo "selected"; ?> value="TUMBAO"> TUMBAO </option>
                                        </select>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="origen" class="control-label">Origen (*):</label>
                                        <input value="<?php echo $propiedades["origen"]; ?>" class="form-control" name="origen" id="origen">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="row">
                               
                                <div class="col-xs-5">
                                    <div class="form-group clearfix">
                                        <label for="telefono" class="control-label">Región (*):</label>
                                        <?php echo formElementSelectRegionUsuario("region", array($propiedades["region"]), array("class" => "form-control")); ?>
                                        
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                        
                                <div class="col-xs-4">
                                    <div class="form-group clearfix">
                                        <label for="fecha_de_nacimiento" class="control-label">Comuna:</label>
                                        <?php echo formElementSelectComuna("comuna", $propiedades["comuna"], $propiedades["region"]); ?>
                                        
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="profundidad" class="control-label">Profundidad:</label>
                                        <input value="<?php echo $propiedades["profundidad"]; ?>" class="form-control" name="profundidad" id="profundidad">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="temperatura" class="control-label">Tº del Producto:</label>
                                        <input value="<?php echo $propiedades["temperatura"]; ?>" class="form-control" name="temperatura" id="temperatura">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="temperatura" class="control-label">Tº del agua:</label>
                                        <input value="<?php echo $propiedades["temperatura_agua"]; ?>" class="form-control" name="temperatura_agua" id="temperatura_agua">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <!--<div class="col-xs-3">
                                    <div class="form-group clearfix">
                                        <label for="vp" class="control-label">N° VP:</label>
                                        <input value="<?php echo $propiedades["vp"]; ?>" class="form-control" name="vp" id="vp">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>-->
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="observaciones" class="control-label ">Observaciones:</label>
                                        <textarea name="observaciones" class="form-control" id="observaciones"><?php echo $propiedades["observaciones"]; ?></textarea>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="row">
                                <div class="col-xs-12">

                                </div>
                            </div>-->
   	
                        </div>
                        </div>
                        </div>
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
                            
            <div class="row top-spaced">
                <div class="col-xs-12 text-right">
                <div class="form-group">
                    <div class="col-sm-12">
                        <button id="guardar-continuar" class="btn btn-green" type="button">
                            Guardar y continuar con siguiente muestra <i class="fa fa-arrow-right"></i>
                        </button>
                        
                        <button id="guardar-cerrar" class="btn btn-warning" type="button">
                            <i class="fa fa-floppy-o"></i> Guardar y cerrar
                        </button>
                        
                        <button class="btn btn-white" type="reset" onClick="document.location.href='<?php echo base_url("marea_roja/index") ?>'">
                            <i class="fa fa-ban"></i> Cerrar
                        </button>
                    </div>
                </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>