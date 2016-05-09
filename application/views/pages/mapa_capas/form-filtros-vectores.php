<div id="contenedor-formulario-vectores" class="form-busqueda hidden">
    <form id="formulario-vectores">
    <div class="row">
        <div class="col-lg-12">
            <button id="configuracion-filtros-vectores" class="btn btn-white"> 
                <i class="fa en-linea">
                    <img width="20px" src="<?php echo base_url("assets/img/markers/otros/radar.png") ; ?>">
                </i> 
                <div id="configuracion-filtros-resumen" class="en-linea">
                    <strong>Vectores:</strong> Fechas hallasgo: todas, Resultado: todos, Estadío: todos
                </div>
            </button>
        </div>
    </div>
    
    <div id="filtros-vectores" style="display:none">
        <div class="panel panel-primary">
            <div class="panel-body">
            <div class="form-group clearfix">
                <label class="col-sm-12 control-label required"> <strong> Fecha hallazgo </strong>:</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_hallazgo_desde_casos" class="col-sm-3 text-left control-label required">Desde:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_hallazgo_desde_casos" type=="text" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group clearfix">
                        
                        <label for="fecha_hallazgo_hasta_casos" class="col-sm-3 text-right control-label required">Hasta:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="fecha_hallazgo_hasta_casos" type="text" value="" class="form-control" />
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
                
            <div class="form-group clearfix">
                <label for="vectores_resultado" class="col-sm-12 control-label required"> <strong> Resultado </strong> :</label>
                <div class="col-sm-6">
                     <select name="vectores_resultado" id="vectores_resultado" class="form-control">
                        <option value="">TODOS</option>
                        <option value="POSITIVO">POSITIVO</option>
                        <option value="NEGATIVO">NEGATIVO</option>
                    </select>
                    <span class="help-block hidden"></span>
                </div>
            </div>
            
            <div id="contenedor-estadio" class="hidden"> 
                <div class="form-group clearfix">
                    <label for="vectores_estadio" class="col-sm-12 control-label required"> <strong> Estadío </strong> :</label>
                    <div class="col-sm-12">
                         <select name="vectores_estadio[]" id="vectores_estadio" class="form-control select2-tags" multiple="true">
                            <option value=""></option>
                            <option value="LARVA">LARVA</option>
                            <option value="PUPA">PUPA</option>
                            <option value="ADULTO">ADULTO</option>
                        </select>
                        <span class="help-block hidden"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group clearfix">
                <div class="col-sm-4"></div>
                <div class="col-sm-8 text-right">
                    <a href="#">
                        <i id="cerrar-filtros-vectores" class="fa fa-chevron-up" title="Cerrar filtros"></i>
                    </a>
                </div>
           </div>
        </div>
        </div>
    </div>    
    </form>
</div>