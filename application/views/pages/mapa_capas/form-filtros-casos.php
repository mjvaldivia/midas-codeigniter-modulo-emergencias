<div id="formulario-casos-rango" class="form-busqueda hidden">
    <form id="formulario-casos">
    <div class="row">
        <div class="col-lg-12">
            <button id="configuracion-filtros-casos" class="btn btn-white"> 
                <i class="fa en-linea">
                    <img width="20px" src="<?php echo base_url("assets/img/markers/epidemiologico/caso_sospechoso.png") ; ?>">
                </i> 
                <div id="configuracion-filtros-resumen" class="en-linea">
                    <strong>Casos febriles:</strong> Fechas: todas, Estado: todos
                </div>
            </button>
        </div>
    </div>
    
    <div id="filtros-casos" style="display:none">
        <div class="panel panel-primary">
            <div class="panel-body">
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Fecha ingreso </strong>:</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_ingreso_desde_casos" class="col-sm-3 text-left control-label required">Desde:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_ingreso_desde_casos" type=="text" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_ingreso_hasta_casos" class="col-sm-3 text-right control-label required">Hasta:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_ingreso_hasta_casos" type="text" value="" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Fecha inicio sintomas </strong>:</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_inicio_desde_casos" class="col-sm-3 text-left control-label required">Desde:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_inicio_desde_casos" type=="text" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_inicio_hasta_casos" class="col-sm-3 text-right control-label required">Hasta:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_inicio_hasta_casos" type="text" value="" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-group clearfix">
                <label for="estado_casos" class="col-sm-12 control-label required"> <strong> Estado </strong> :</label>
                <div class="col-sm-6">
                     <select name="estado_casos" id="estado_casos" class="form-control">
                        <option value="">Todos</option>
                        <option value="NULL"><?php echo nombreFormularioEstado(null); ?></option>
                        <option value="1"><?php echo nombreFormularioEstado(1); ?></option>
                        <option value="2"><?php echo nombreFormularioEstado(2); ?></option>
                        <option value="3"><?php echo nombreFormularioEstado(3); ?></option>
                    </select>
                    <span class="help-block hidden"></span>
                </div>
            </div>
            
            <div id="enfermedades_casos" class="hidden">
                <div class="form-group clearfix">
                    <label class="col-sm-12 control-label required"> <strong> Fecha confirmación </strong>:</label>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group clearfix">

                            <label for="fecha_confirmacion_desde_casos" class="col-sm-3 text-left control-label required">Desde:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="fecha_confirmacion_desde_casos" type=="text" class="form-control" />
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group clearfix">

                            <label for="fecha_confirmacion_hasta_casos" class="col-sm-3 text-right control-label required">Hasta:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="fecha_confirmacion_hasta_casos" type="text" value="" class="form-control" />
                                    <span class="help-block hidden"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label for="enfermedades_casos" class="col-sm-12 control-label"> <strong> Enfermedades </strong>:</label>
                    <div class="col-sm-12">
                        <?php echo formSelectEnfermedades("enfermedades_casos[]", array()); ?>
                        <span class="help-block hidden"></span>
                    </div>
                </div> 
            </div>
            <div class="form-group clearfix">
                <div class="col-sm-4"></div>
                <div class="col-sm-8 text-right">
                    <a href="#">
                        <i id="cerrar-filtros-casos-febriles" class="fa fa-chevron-up" title="Cerrar filtros"></i>
                    </a>
                </div>
           </div>
        </div>
        </div>
    </div>    
    </form>
</div>