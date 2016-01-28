<?php echo $js; ?>
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

<!-- Input para buscar direcciones -->
<div class="row hidden">
    <div id="busqueda" class="input-group">
        <span class="input-group-addon"><i class="fa fa-search"></i></span>
        <input id="pac-input" class="form-control" type="text" placeholder="Buscar dirección">
    </div>
</div>

<!-- Menu slideup para mostrar elementos cargados en el mapa -->
<div class="row hidden">
    <div id="slideup-menu" class="top-menu">
        <div class="top-menu-main">
            <ul id="lista_capas_agregadas" class="demo-menu">
                
            </ul>
            <a href="#" class="menu-item-text">Capas <span id="cantidad_capas_agregadas" class="badge">0</span></a> 
        </div>
        <div class="top-menu-main">
            <ul class="demo-menu">
                
            </ul>
            <a href="#" class="menu-item-text">Elementos <span class="badge">0</span></a> 
        </div>
        <div class="top-menu-main">
            <ul class="demo-menu">
                
            </ul>
            <a href="#" class="menu-item-text">Archivos importados <span class="badge">0</span></a> 
        </div>
    </div>
</div>

<!-- Mapa -->
<div class="row row-mapa">
    <div id="mapa">
        <div class="col-lg-12 text-center" style="padding-top: 200px">
            <i class="fa fa-4x fa-spin fa-spinner"></i>
        </div>
    </div>
</div>

<?= loadJS("assets/js/modulo/mapa/front-end.js"); ?>