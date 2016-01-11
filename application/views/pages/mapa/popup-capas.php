<form name="form_capas" id="form_capas" method="post" >

<div class="row">
    <div class="col-lg-12" data-row="5">
        <table id="grilla-capas" class="table table-hover datatable paginada">
            <thead>
                <tr>
                    <th></th>
                    <th>Icono/Color</th>
                    <th>Nombre</th>                
                </tr>
            </thead>
            <tbody>
                <?php foreach($capas as $row){ ?>
                <tr>
                    <td width="5%" align="center">
                       <input <?php echo visorCapasSeleccionadasChecked($row["cap_ia_id"], $seleccionadas);?> class="seleccion-capa" value="<?php echo $row["cap_ia_id"]; ?>" type="checkbox" id="chk_capa_<?php echo $row["cap_ia_id"]; ?>" name="chk_capa[<?php echo $row["cap_ia_id"]; ?>]"/>
                    </td>
                    <td align="center" width="20%">
                        <?php echo getCapaPreview($row["cap_ia_id"]); ?>
                    </td>
                    <td width="75%">
                        <?php echo $row["cap_c_nombre"]; ?>
                    </td>      
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
    
</form>