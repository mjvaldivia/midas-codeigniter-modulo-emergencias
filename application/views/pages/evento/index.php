<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1> Eventos
                <small><i class="fa fa-arrow-right"></i> Gestión de Eventos</small>
                <?php if(permisoEvento("ingresar")){ ?>
                <div class="pull-right">
                    <a href="#" id="nueva" class="btn btn-green btn-square">
                        <i class="fa fa-plus"></i>
                        Nuevo Evento
                    </a>
                </div>
                <?php } ?>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio </a></li>
                <li><i class="fa fa-bell"></i> Eventos </li>
                <li class="active"><i class="fa fa-bell"></i> Ingreso </li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">           
        <form name="busqueda" id="busqueda" class=" form-busqueda">
            <div class="portlet portlet-default">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="" class="control-label">Año</label>
                                <input id="filtro_year" name="filtro_year" type="text" class="form-control" value="<?= $year ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="TiposEmergencias" class="control-label">Tipo de Evento</label>
                                <?= formElementSelectEmergenciaTipo("filtro_id_tipo", "",array("class" => "form-control") ) ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group clearfix">
                                <label for="iEstadoAlarma" class="control-label">Estado</label>
                                <?php echo formElementSelectAlarmaEstados("filtro_id_estado", $id_estado, array("class" => "form-control"))?>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group clearfix">
                                <label for="" class="control-label">Nivel</label>
                                <select id="filtro_nivel" name="filtro_nivel" type="text" class="form-control">
                                    <option value="0" selected>Todos</option>
                                    <option value="1">Nivel I</option>
                                    <option value="2">Nivel II</option>
                                    <option value="3">Nivel III</option>
                                    <option value="4">Nivel IV</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button id="btnBuscarAlarmas" type="button" class="btn btn-primary btn-square btn-buscar top-spaced">
                                <i class="fa fa-search"></i>
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
                            
        <div id="pResultados" class="portlet portlet-default">
            <div class="portlet-body table-responsive">
                <div id="grilla-alarma"></div>
                <div id="grilla-alarma-loading" class="col-lg-12 text-center"> <i class="fa fa-4x fa-spin fa-spinner"></i> </div>
            </div>
        </div>
    </div>
</div>

<?= loadCSS("assets/js/library/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
