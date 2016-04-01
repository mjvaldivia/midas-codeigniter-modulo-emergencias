<div id="formulario-casos-rango" class="form-busqueda hidden">
    
    <div class="row">
        <div class="col-lg-12">
            <button id="configuracion-filtros-casos" class="btn btn-white"> 
                <i class="fa en-linea">
                    <img width="20px" src="http://development.emergencias.midas.cl/assets/img/markers/epidemiologico/caso_sospechoso.png">
                </i> 
                <div id="configuracion-filtros-resumen" class="en-linea">
                    Fechas: todas, Estado: todos
                </div>
            </button>
        </div>
    </div>
    
    <div id="filtros-casos" style="display:none">
        <div style="height: auto; width: 100%; background-color: #FFF; padding-top: 10px; padding-bottom: 10px">
            <div class="form-group clearfix">
                <label for="estado_casos" class="col-sm-12 control-label required">Fecha inicio sintomas :</label>
            </div>
            <div class="form-group clearfix">
                <label for="fecha_desde_casos" class="col-sm-4 text-right control-label required">Desde :</label>
                <div class="col-sm-8">
                    <input id="fecha_desde_casos" type=="text" class="form-control" />
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="form-group clearfix">
                <label for="fecha_hasta_casos" class="col-sm-4 text-right control-label required">Hasta :</label>
                <div class="col-sm-8">
                    <input id="fecha_hasta_casos" type="text" value="" class="form-control" />
                    <span class="help-block hidden"></span>
                </div>
            </div>
            <div class="form-group clearfix">
                <label for="estado_casos" class="col-sm-12 control-label required">Estado :</label>
                <div class="col-sm-12">
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
            <div id="enfermedades_casos" class="form-group clearfix hidden">
                <label for="enfermedades_casos" class="col-sm-12 control-label">Enfermedades:</label>
                <div class="col-sm-12">
                    <?php echo formSelectEnfermedades("enfermedades_casos[]", array()); ?>
                    <span class="help-block hidden"></span>
                </div>
            </div>  
            <div class="form-group clearfix">
                <div class="col-sm-4"></div>
                <div class="col-sm-8 text-right">
                    <input type="button" id="btn-buscar-casos-febriles" class="btn btn-primary" value="Filtrar" />
                </div>
           </div>
        </div>
    </div>    
</div>