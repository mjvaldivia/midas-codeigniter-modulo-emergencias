<table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
    <thead>
        <tr>
            <th>Código</th>
            <th width="10%">Fecha</th>
            <th width="10%">Estado</th>
            <th width="10%">Diagnostico clínico</th>
            <th width="10%">Médico</th>
            <th width="10%">Run</th>
            <th width="15%">Nombre</th>
            <th width="20%">Dirección</th>
            <th width="5%">Opciones</th>				
        </tr>
    </thead>
    <tbody>
        <?php if(count($lista)>0){ ?>
        <?php foreach($lista as $row){ ?>
        <tr>
            <td width="10%">Caso N°<?php echo $row["id"]; ?></td>
            <td width="10%"><?php echo $row["fecha"]; ?></td>
            <td width="10%">
                <?php if($row["id_estado"] == ""){ ?>
                <div class="badge alert-warning">Caso sospechoso</div>
                <?php }elseif($row["id_estado"] == 1) { ?>
                <div class="badge alert-danger">Confirmado</div>
                <?php }elseif($row["id_estado"] == 2) { ?>
                <div class="badge alert-success">Descartado</div>
                <?php }elseif($row["id_estado"] == 3) { ?>
                <div class="badge alert-info">No concluyente</div>
                <?php } ?>
            </td>
            <td width="20%"><?php echo $row["diagnostico"]; ?></td>
            <td width="10%"><?php echo nombreUsuario($row["id_usuario"]); ?></td>
            <td width="10%"><?php echo $row["run"]; ?></td>
            <td width="15%"><?php echo $row["nombre"]; ?></td>
            <td width="20%"><?php echo $row["direccion"]; ?></td>
            <td align="center" width="5%">
                <div style="width: 150px">
                    
                    <?php // if(puedeVerReporteEmergencia("casos_febriles")) { ?> 
                    <a href="<?php echo base_url("formulario/pdf/id/" . $row["id"]); ?>" target="_blank" title="Pdf" class="btn btn-sm btn-default">
                        <i class="fa fa-file"></i>
                    </a>
                    <?php //} ?>
                    
                    
                    <?php if(($row["enviado"] == 0 and !puedeFinalizarEmergencia("casos_febriles")) OR puedeFinalizarEmergencia("casos_febriles")) { ?>
                    
                    <?php if(puedeEditar("casos_febriles")) { ?> 
                    <button onclick="document.location.href='<?php echo base_url("formulario/editar/?id=" . $row["id"]); ?>'" title="editar" class="btn btn-sm btn-success" type="button" >
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    
                    <?php if(puedeEliminar("casos_febriles")) { ?>
                    <button title="Eliminar" class="btn btn-sm btn-danger caso-eliminar" type="button"  data="<?php echo $row["id"] ?>" href="#" >
                        <i class="fa fa-trash"></i>
                    </button>
                    <?php } ?>
                    
                    <?php } ?>
                </div>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>

