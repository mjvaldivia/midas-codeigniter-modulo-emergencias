<input type="hidden" name="id_rol" id="id_rol" value="<?php echo $id; ?>" />

<div class="row">
<div class="col-lg-12" data-row="10">
    <table id="grilla" class="table table-hover datatable paginada">
        <thead>
            <tr>
                <th></th>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Region</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="10%" align="center">    
                    <button data-rel="<?php echo $row["usu_ia_id"]; ?>" class="btn btn-xs btn-danger quitar-usuario-rol" title="Quitar usuario del rol">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
                <td>
                    <?php echo $row["usu_c_rut"]; ?>
                </td>
                <td>
                    <?php echo $row["usu_c_nombre"]; ?> <?php echo $row["usu_c_apellido_paterno"]; ?> <?php echo $row["usu_c_apellido_materno"]; ?> 
                </td>
                <td> 
                    <?php echo $row["usu_c_email"]; ?>
                </td>
                <td>
                    <?php echo nombreRegion($row["reg_ia_id"]); ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>