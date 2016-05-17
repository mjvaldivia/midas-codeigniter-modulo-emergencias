<table id="grilla-emergencia" class="table table-hover datatable paginada">
    <thead>
        <tr>
            <th>Código</th>
            <th width="10%">Fecha</th>
            <th width="5%">Semana</th>
            <th width="10%">Estado</th>
            <th width="10%">Diagnóstico clínico</th>
            <th width="10%">Médico</th>
            
            <?php if(permisoCasosFebriles("datos_personales")) { ?>
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
            <td width="5%"><div class="label blue"><?php echo $row["semana"]; ?></div></td>
            <td width="10%">
                <?= casoFebrilNombreEstado($row["id_estado"]); ?>
            </td>
            <td width="20%"><?php echo $row["diagnostico"]; ?></td>
            <td width="10%"><?php echo layoutUsuarioNombre($row["id_usuario"]); ?></td>
            
            <?php if(permisoCasosFebriles("datos_personales")) { ?>
                <td width="10%"><?php echo $row["run"]; ?></td>
                <td width="20%"><?php echo $row["nombre"]; ?></td>
            <?php } ?>
            
            <td width="20%"><?php echo $row["direccion"]; ?></td>
            <td align="center" width="5%">
                <div style="width: 150px">

                    <a href="<?php echo base_url(getController() . "/pdf/id/" . $row["id"]); ?>" target="_blank" title="Pdf" class="btn btn-sm btn-default">
                        <i class="fa fa-file"></i>
                    </a>

                    <?php if(($row["enviado"] == 0 and !permisoCasosFebriles("conclusiones")) OR permisoCasosFebriles("conclusiones")) { ?>
                    
                    <?php if(permisoCasosFebriles("editar")) { ?> 
                    <button onclick="document.location.href='<?php echo base_url(getController() . "/editar/?id=" . $row["id"]); ?>'" title="editar" class="btn btn-sm btn-success" type="button" >
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    
                    <?php if(permisoCasosFebriles("eliminar")) { ?>
                    <button title="Eliminar" class="btn btn-sm btn-danger caso-eliminar" type="button"  data="<?php echo $row["id"] ?>" href="#" >
                        <i class="fa fa-trash"></i>
                    </button>
                    <?php } ?>
                    
                    <?php } else { ?>
                    <button onclick="javascript:void(0)" data-toggle="tooltip" data-toogle-param="arriba" title="Enviado a delegado de epidemiología" class="btn btn-sm btn-default disabled" type="button" >
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>

