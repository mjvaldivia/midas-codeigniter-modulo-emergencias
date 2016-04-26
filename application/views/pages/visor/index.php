<?php echo $js; ?>

<div class="row-mapa">

        <div class="row">
            <div class="collapse navbar-collapse hidden" id="menu-derecho">
                <ul class="nav navbar-nav navbar-left">
                
                <li>
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o"></i> Archivo <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <?php if($guardar):?>
                        <li>
                            <a id="btn-guardar" href="javascript:void(0)"><i class="fa fa-save"></i> Guardar</a>
                        </li>
                        <?php endif;?>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="javascript:void(0)"><i class="fa fa-upload"></i> Exportar</a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a  id="btn-exportar-kml" href="javascript:void(0)"> <i class="fa fa-map"></i> Kmz </a>
                                </li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="javascript:void(0)"><i class="fa fa-download"></i> Importar</a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a  id="btn-importar-kml" href="javascript:void(0)"> <i class="fa fa-map"></i> Kml/Kmz </a>
                                </li>
                                <!--<li>
                                    <a id="btn-importar-excel" href="#"> <i class="fa fa-table"></i> Excel </a>
                                </li>-->
                                <li class="divider"></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                
                <li class="dropdown dropdown-large">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-object-group"></i> Capas <b class="caret"></b></a>

                    <ul id="capas-menu" class="dropdown-menu dropdown-menu-large row" style="overflow-y: scroll; width:90%">
                        <li class="col-sm-3">
                            <ul id="capas-columna-1" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-2" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-3" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-4" class="capas-columna">
                                <li class="dropdown-header"> OTROS </li>
                                <li><a id="btn-importar-sidco" href="javascript:void(0)"><input type="checkbox" name="importar_sidco" id="importar_sidco" value="1"/> <i class="fa fa-fire"></i> Sidco - Conaf </a></li>
                                <?php if(puedeAbrirVisorEmergencia("casos_febriles")) { ?>
                                <li class="dropdown-header"> ISLA DE PASCUA </li>
                                <li><a id="btn-importar-rapanui-casos" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_casos" id="importar_rapanui_casos" value="1"/> <i class="fa"><img width="20px" src="<?php echo base_url("assets/img/markers/epidemiologico/caso_sospechoso.png") ?>"></i> Casos febriles </a></li>
                                <li><a id="btn-importar-rapanui-zona" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_zonas" id="importar_rapanui_zonas" value="1"/> <i style="width:20px; text-align: center" class="fa fa-circle-o"></i> Zonas </a></li>
                                <li><a id="btn-importar-rapanui-embarazadas" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_embarazo" id="importar_rapanui_embarazo" value="1"/> <i class="fa"><img width="20px" src="<?php echo base_url("assets/img/markers/otros/embarazada.png") ?>"></i> Embarazadas </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown dropdown-large">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-building"></i> Instalaciones <b class="caret"></b></a>

                    <ul id="instalaciones-menu" class="dropdown-menu dropdown-menu-large row" style="overflow-y: scroll">
                        <li class="col-sm-3">
                            <ul id="instalaciones-columna-1" class="instalaciones-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="instalaciones-columna-2" class="instalaciones-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="instalaciones-columna-3" class="instalaciones-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="instalaciones-columna-4" class="instalaciones-columna">

                            </ul>
                        </li>
                    </ul>
                </li>
                </ul>
             </div><!-- /.navbar-collapse -->
        </div>
      

        <!-- Menu slideup para mostrar elementos cargados en el mapa -->
        <div class="row hidden">
            <div class="col-lg-12">
                <div id="slideup-menu" class="top-menu">
                    <div class="top-menu-main">
                        <ul id="lista_capas_agregadas" class="demo-menu">

                        </ul>
                        <a href="javascript:void(0)" class="menu-item-text">Capas <span id="cantidad_capas_agregadas" class="badge">0</span></a> 
                    </div>
                    <div class="top-menu-main">
                        <ul id="lista_elementos_agregados" class="demo-menu">

                        </ul>
                        <a href="javascript:void(0)" class="menu-item-text">Elementos <span id="cantidad_elementos_agregados" class="badge">0</span></a> 
                    </div>
                    <div class="top-menu-main">
                        <ul id="lista_importados_agregados" class="demo-menu">

                        </ul>
                        <a href="javascript:void(0)" class="menu-item-text">Importados <span id="cantidad_elementos_importados" class="badge">0</span></a> 
                    </div>
                </div>
            </div>
        </div>

   
        <div id="mapa" style="height: 2000px">
            <div class="col-lg-12 text-center" style="padding-top: 200px">
                <i class="fa fa-4x fa-spin fa-spinner"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?= loadJS("assets/js/visor.js"); ?>
<?= loadJS("assets/js/modulo/visor/editor.js"); ?>
<?= loadJS("assets/js/modulo/visor/capa.js"); ?>
<?= loadJS("assets/js/modulo/visor/layout/capas.js"); ?>
<?= loadJS("assets/js/modulo/visor/layout/ambito.js"); ?>
<?= loadJS("assets/js/modulo/visor/layout/regiones.js"); ?>