<form id="form-permisos" name="form_permisos" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    
    <div class="row">
        <?php foreach($lista as $row){ ?>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="col-sm-12 control-label"><?php echo $row["per_c_nombre"] ?></label>
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            Ver
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            Editar
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            Eliminar
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" disabled="" value="">
                            Finalizar
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    
</form>

