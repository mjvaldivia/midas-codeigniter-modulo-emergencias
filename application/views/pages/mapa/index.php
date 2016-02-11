<?php echo $js; ?>

<div class="row-mapa">

        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

        <div class="row">
            <div class="collapse navbar-collapse hidden" id="menu-derecho">
                <ul class="nav navbar-nav navbar-right">
                
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o"></i> Archivo <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li>
                            <a id="btn-guardar" href="#"><i class="fa fa-save"></i> Guardar</a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="#"><i class="fa fa-upload"></i> Exportar</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a  id="btn-importar-kml" href="#"> <i class="fa fa-map"></i> Kmz </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#"><i class="fa fa-download"></i> Importar</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a  id="btn-importar-kml" href="#"> <i class="fa fa-map"></i> Kml/Kmz </a>
                                </li>
                                <li>
                                    <a  id="btn-importar-excel" href="#"> <i class="fa fa-table"></i> Excel </a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-edit"></i> Editar <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a id="btn-ubicacion-emergencia" href="#"><i class="fa fa-bullhorn"></i> Nueva Ubicación emergencia</a></li>
                        
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-eye"></i> Ver <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li class="dropdown-submenu">
                            <a href="#"><i class="fa fa-object-group"></i> Capas</a>
                            <ul class="dropdown-menu">
                                <li><a id="btn-capas-gestionar" href="#"><i class="fa fa-gears"></i> Gestionar capas</a></li>
                                <li class="divider"></li>
                                <?php echo visorMenuCapasCategoria($id); ?>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="#"><i class="fa fa-cloud-download"></i> Datos externos</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a id="btn-importar-sidco" href="#"><input type="checkbox" name="importar_sidco" id="importar_sidco" value="1"/> <i class="fa fa-fire"></i> Sidco - Conaf </a>
                                </li>
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
                        <a href="#" class="menu-item-text">Capas <span id="cantidad_capas_agregadas" class="badge">0</span></a> 
                    </div>
                    <div class="top-menu-main">
                        <ul id="lista_elementos_agregados" class="demo-menu">

                        </ul>
                        <a href="#" class="menu-item-text">Elementos <span id="cantidad_elementos_agregados" class="badge">0</span></a> 
                    </div>
                    <!--<div class="top-menu-main">
                        <ul class="demo-menu">

                        </ul>
                        <a href="#" class="menu-item-text">Archivos importados <span class="badge">0</span></a> 
                    </div>-->
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
<?= loadJS("assets/js/mapa-visor.js"); ?>