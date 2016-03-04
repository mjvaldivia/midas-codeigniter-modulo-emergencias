<li>
<a href="javascript:void(0)">
    <div class="row">
        <div class="col-xs-12">
            <div class="checkbox checkbox-menu">
                <div class="col-xs-12">
                <label>
                    <div style="float:left">
                        <input <?php echo visorCapasSeleccionadasChecked($id, $seleccionadas);?> class="menu-capa-checkbox" type="checkbox" value="<?php echo $id; ?>" />
                    </div>
                    <div style="margin-left:10px; width:30px; float:left"><?php echo getSubCapaPreview($id) ?></div>
                    <div style="margin-left:50px"><?php echo $nombre; ?></div>
                </label>
                </div>
            </div>
        </div>
    </div>
</a>
</li>
<li class="divider"></li>


