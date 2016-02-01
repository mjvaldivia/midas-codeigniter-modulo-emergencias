<li class="dropdown-submenu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nombre; ?></a>
    <ul class="dropdown-menu" style="min-width:400px">
    <!--<li>
        <a href="#">
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-5">
                    <div class="checkbox">
                
                    <label> 
                        <input type="checkbox" class="capas-seleccionar-todo" /> <small>[seleccionar todo]</small> 
                    </label>
                    
                    </div>
                </div>
                <div class="col-xs-5">
                    <div class="checkbox">
                
                    <label> 
                        <input type="checkbox" class="capas-borrar-todo" /> <small>[borrar todo]</small> 
                    </label>
            
                    </div>
                </div>
                <div class="col-xs-1"></div>
            </div>
        </a>
    </li>
    <li class="divider"></li>-->
    <?php echo visorMenuCapasDetalle($id_capa, $id_emergencia); ?>
    </ul>
</li>


