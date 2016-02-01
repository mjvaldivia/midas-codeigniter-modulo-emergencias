<?php echo $js; ?>

<div class="row-mapa">

        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

        <div class="row">
            <div class="collapse navbar-collapse hidden" id="menu-derecho">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-clone"></i> Capas <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a id="btn-capas-gestionar" href="#"><i class="fa fa-gears"></i> Gestionar capas</a></li>
                        <li class="divider"></li>
                        <?php echo visorMenuCapasCategoria($id); ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-download"></i> Importar<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a id="btn-importar-kml" href="#"><i class="fa fa-map"></i> Kml/Kmz</a></li>
                      <li><a id="btn-importar-sidco" href="#"><i class="fa fa-fire"></i> Sidco - Conaf</a></li>
                    </ul>
                </li>
                <li><a id="btn-ubicacion-emergencia" href="#"><i class="fa fa-bullhorn"></i> Ubicación emergencia</a></li>
                <li class="btn-success" >
                    <a id="btn-guardar" style="color: #FFF" href="#"><i class="fa fa-save"></i> Guardar</a>
                </li>
                </ul>
             </div><!-- /.navbar-collapse -->
        </div>
        
        
        
        <!-- Input para buscar direcciones -->
        <div class="row hidden">
            
            <div id="busqueda" class="input-group" style="width:300px">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input id="pac-input" class="form-control" type="text" placeholder="Buscar dirección">
            </div>
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