<table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
    <thead>
        <tr>
            <th>Código</th>
            <th width="10%">Fecha ingreso</th>
            <th width="10%">FPP</th>
            <th width="10%">Médico</th>
            
            <?php if(puedeVerFormularioDatosPersonales("casos_febriles")) { ?>
            <th width="10%">Run</th>
            <th width="20%">Nombre</th>
            <?php } ?>
            
            <th width="15%">Dirección</th>
            <th width="5%">Opciones</th>				
        </tr>
    </thead>
    <tbody>
        <?php if(count($lista)>0){ ?>
        <?php foreach($lista as $row){ ?>
        <tr>
            <td width="10%">Caso N°<?php echo $row["id"]; ?></td>
            <td width="10%"><?php echo $row["fecha"]; ?></td>
            <td width="10%"><div class="label blue"><?php echo $row["fpp"]; ?></div></td>


            <td width="10%"><?php echo nombreUsuario($row["id_usuario"]); ?></td>
            
            <?php if(puedeVerFormularioDatosPersonales("casos_febriles")) { ?>
            <td width="10%"><?php echo $row["run"]; ?></td>
            <td width="20%"><?php echo $row["nombre"]; ?></td>
            <?php } ?>
            
            <td width="20%"><?php echo $row["direccion"]; ?></td>
            <td align="center" width="5%">
                <div style="width: 150px">

                    <button onclick="document.location.href='<?php echo base_url("embarazo/editar/?id=" . $row["id"]); ?>'" title="editar" class="btn btn-sm btn-success" type="button" >
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

