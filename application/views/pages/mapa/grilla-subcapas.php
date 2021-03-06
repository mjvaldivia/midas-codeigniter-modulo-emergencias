<div class="row">
    <div class="col-lg-12" data-row="5">
        <table id="grilla-capas" class="table table-hover datatable paginada">
            <thead>
                <tr>
                    <th></th>
                    <th>Icono/Color</th>
                    <th align="left">Nombre</th>      
                </tr>
            </thead>
            <tbody>
                <?php if(count($subcapas)>0){ ?>
                    <?php foreach($subcapas as $row){ ?>
                    <tr>
                        <td width="5%" align="center">
                           <input <?php echo visorCapasSeleccionadasChecked($row["geometria_id"], $seleccionadas);?> class="seleccion-capa" value="<?php echo $row["geometria_id"]; ?>" type="checkbox" id="chk_capa_<?php echo $row["geometria_id"]; ?>" name="chk_capa[<?php echo $row["geometria_id"]; ?>]"/>
                        </td>
                        <td align="center" width="20%">
                            <?php echo getSubCapaPreview($row["geometria_id"]); ?>
                        </td>
                        <td align="left" width="55%">
                            <?php echo $row["geometria_nombre"]; ?>
                        </td>      
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

