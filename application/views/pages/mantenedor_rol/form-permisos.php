<form id="form-permisos" name="form_permisos" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id_rol; ?>"/>

    <?php foreach($lista as $row){ ?>
    <div class="col-lg-4">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-list-ul"></i> <?php echo $row["nombre"] ?></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body" style='height: auto'>
                <div class="row"> 
                    
                    <div class="col-sm-4">
                        <input <?php echo checkboxPermisosChecked("ver", $row["permiso"]); ?> data-rel="<?php echo $row["id"] ?>" name="permiso[ver][]" id="ver_<?php echo $row["id"] ?>" class="ver" type="checkbox" value="<?php echo $row["id"] ?>">
                        Ver
                    </div>
                </div>
                <div class="row"> 
                    <div id="permisos_io_<?php echo $row["id"] ?>">
                        <div class="col-sm-4">
                            <input <?php echo checkboxPermisosChecked("ingresar", $row["permiso"]); ?> data-rel="<?php echo $row["id"] ?>" name="permiso[ingresar][]" id="ver_<?php echo $row["id"] ?>"  type="checkbox" value="<?php echo $row["id"] ?>">
                            Ingresar
                        </div>
                        <div class="col-sm-4">
                            <input <?php echo checkboxPermisosChecked("editar", $row["permiso"]); ?> name="permiso[editar][]" id="editar_<?php echo $row["id"] ?>" type="checkbox" value="<?php echo $row["id"] ?>">
                            Editar
                        </div>
                        <div class="col-sm-4">
                            <input <?php echo checkboxPermisosChecked("eliminar", $row["permiso"]); ?> name="permiso[eliminar][]" id="eliminar_<?php echo $row["id"] ?>" type="checkbox" value="<?php echo $row["id"] ?>">
                            Eliminar
                        </div>
             
                        <?php echo htmlPermisosEspeciales($row["id"], $row["permiso"]); ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <?php } ?>
    <div class="clearfix"></div>
</form>

