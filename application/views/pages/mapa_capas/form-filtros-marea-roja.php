<div id="formulario-marea-roja-contenedor" class="form-busqueda hidden">
    <form id="formulario-marea-roja">
    <div class="row">
        <div class="col-lg-12">
            <button id="configuracion-filtros-marea-roja" class="btn btn-white"> 
                <i class="fa fa-search"></i> 
                <div id="configuracion-filtros-marea-roja-resumen" class="en-linea">
                    <strong>Marea roja:</strong> Fechas muestra: todas, Recurso: todos
                </div>
            </button>
        </div>
    </div>
    
    <div id="filtros-marea-roja" style="display:none">
        <div class="panel panel-primary">
            <div class="panel-body">

  
            
            
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Fecha de toma de muestra </strong>:</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="marea_roja_fecha_muestra_desde" class="col-sm-3 text-left control-label required">Desde:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="marea_roja_fecha_muestra_desde" type=="text" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="marea_roja_fecha_muestra_hasta" class="col-sm-3 text-right control-label required">Hasta:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="marea_roja_fecha_muestra_hasta" type="text" value="" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        
           
            <div class="form-group clearfix">
                <label for="marea_roja_recurso" class="col-sm-12 control-label required"> <strong> Recurso </strong> :</label>
                <div class="col-sm-12">
                     <select name="marea_roja_recurso[]" id="marea_roja_recurso" class="form-control select2-tags" multiple="true">
                        <option value="ALMEJAS"> ALMEJAS </option>
                        <option value="ALMEJA JULIANA"> ALMEJA JULIANA </option>
                        <option value="COCHAYUYO"> COCHAYUYO </option>
                        <option value="CHOLGAS"> CHOLGAS </option>
                        <option value="CHORITO"> CHORITO </option>
                        <option value="CHORITOS QUILMAHUE"> CHORITOS QUILMAHUE </option>
                        <option value="CHORO"> CHORO </option>
                        <option value="CHORO MALTÓN"> CHORO MALTÓN </option>
                        <option value="CHORO ZAPATO"> CHORO ZAPATO </option>
                        <option value="CULENGUE"> CULENGUE </option>
                        <option value="LAPA"> LAPA </option>
                        <option value="LOCO"> LOCO </option>
                        <option value="LUCHE"> LUCHE </option>
                        <option value="MACHAS"> MACHAS </option>
                        <option value="NAVAJUELA"> NAVAJUELA </option>
                        <option value="OSTRA CH"> OSTRA CH </option>
                        <option value="OSTRAS JP"> OSTRAS JP </option>
                        <option value="OSTRAS"> OSTRAS </option>
                        <option value="PICOROCO"> PICOROCO </option>
                        <option value="PIURE"> PIURE </option>
                        <option value="TUMBAO"> TUMBAO </option>
                    </select>
                    <span class="help-block hidden"></span>
                </div>
            </div>
                
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Colores </strong>:</label>
            </div>
                
            <div id="marea-roja-contenedor-filtro-colores" class="form-group clearfix">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-only="ND" value="1" name="" class="marea-roja-color">
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-verde.png") ?>">
                            </i> &equals; ND
                        </div>

                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="-1" data-to="49" value="1" name="" class="marea-roja-color">
                            0 &LT;
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-azul.png") ?>">
                            </i> 
                            &LT; 50
                        </div>
                    </div>
                </div>    
                <div class="row top-spaced">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="50" data-to="79" value="1" name="" class="marea-roja-color">
                            50 &LT; &equals;
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-amarillo.png") ?>">
                            </i> &LT; 80
                        </div>

                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="80" data-to="" value="1" name="" class="marea-roja-color">
                            80 &LT; &equals;
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-rojo.png") ?>">
                            </i> 
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div id="marea-roja-pm-contenedor-filtro-colores" class="form-group clearfix">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-only="ND" value="1" name="" class="marea-roja-color">
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-verde.png") ?>">
                            </i> &equals; ND
                        </div>
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="1" data-to="199" value="1" name="" class="marea-roja-color">
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-azul.png") ?>">
                            </i> &LT; 200
                        </div>
                        
                        
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="200" data-to="1000" value="1" name="" class="marea-roja-color">
                            200 &LT;
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-amarillo.png") ?>">
                            </i> &LT; 1000
                        </div>
                        <div class="col-lg-6">
                            <input type="checkbox" checked="checked" data-from="1001" data-to="" value="1" name="" class="marea-roja-color">
                            1000 &LT;
                            <i class="fa">
                            <img src="<?php echo base_url("assets/img/markers/marisco/marcador-rojo.png") ?>">
                            </i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Resultados </strong>:</label>
            </div>
            <div class="form-group clearfix">
                <div class="col-sm-12">
                    <div id="marea_roja_resultados"></div>
                </div>
            </div>
            
            <div class="form-group clearfix top-spaced">
                <div class="col-sm-4"></div>
                <div class="col-sm-8 text-right">
                    <a href="#">
                        <i id="cerrar-filtros-marea-roja" class="fa fa-chevron-up" title="Cerrar filtros"></i>
                    </a>
                </div>
           </div>
        </div>
        </div>
    </div>    
    </form>
</div>