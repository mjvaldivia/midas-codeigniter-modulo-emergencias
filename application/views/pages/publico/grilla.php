<table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
    <thead>
        <tr>
            <th width="20%">Fecha</th>
            <th width="35%">Nombre</th>
            <th width="40%">Dirección</th>
            <th width="5%">Opciones</th>				
        </tr>
    </thead>
    <tbody>
        <?php if(count($lista)>0){ ?>
        <?php foreach($lista as $row){ ?>
        <tr>
            <td width="20%"><?php echo $row["fecha"]; ?></td>
            <td width="35%"><?php echo $row["nombre"]; ?></td>
            <td width="40%"><?php echo $row["direccion"]; ?></td>
            <td align="center" width="5%">
                <div style="width: 100px">
                <button onclick="document.location.href='<?php echo base_url("publico/editar/?id=" . $row["id"]); ?>'" title="editar" class="btn btn-sm btn-success" type="button" >
                    <i class="fa fa-edit"></i>
                </button>
                <button title="Eliminar" class="btn btn-sm btn-danger caso-eliminar" type="button"  data="<?php echo $row["id"] ?>" href="#" >
                    <i class="fa fa-trash"></i>
                </button>
                </div>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>

