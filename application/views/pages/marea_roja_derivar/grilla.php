<div data-row="100">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
        <tr>
            <th width="5%">Opciones</th>
            <th>N° de acta</th>
            <th width="10%">Fecha toma de muestra</th>
            <th width="10%">Laboratorio</th>
            <th width="10%">Resultado</th>
            <th width="10%">Recurso</th>
            <th width="20%">Origen</th>
            <th width="15%">Comuna</th>
            <th>Fiscalizador</th>
            
        </tr>
        </thead>
        <tbody>
        <?php if (count($lista) > 0) { ?>
            <?php foreach ($lista as $row) { ?>
                <tr>
                    <td align="left" width="5%">
                        <div style="width: 150px">
                            <?php if (permisoMareaRoja("editar")) { ?>
                                <button data-rel="<?php echo $row["id"]; ?>" title="Derivar muestra" class="btn btn-sm btn-success editar-marea-roja" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php } ?>

                            <!--<?php if (permisoMareaRoja("eliminar")) { ?>
                                <button title="Eliminar" class="btn btn-sm btn-danger caso-eliminar" type="button"
                                        data="<?php echo $row["id"] ?>" href="#">
                                    <i class="fa fa-trash"></i>
                                </button>
                            <?php } ?>-->
                            
                            <?php echo mareaRojaBotonVerActa($row['id'], $row['numero_muestra']); ?>
                        
                        </div>
                    </td>
                    
                    <td width="10%" align="center">
                        <?php echo $row["numero_muestra"]; ?>
                    </td>
                    <td width="10%">
                        <?php echo $row["fecha_muestra"]; ?>
                    </td>
                    <td width="10%" align="center">
                        <?php echo laboratorioNombre($row["id_laboratorio"]); ?>
                    </td>
                    <td width="10%">
                        <?php echo mareaRojaEstadoEsperaResultado($row["resultado"], $row["bo_ingreso_resultado"]); ?>
                    </td>
                    <td width="10%">
                        <?php echo $row["recurso"]; ?>
                    </td>
                    <td width="20%">
                        <?php echo $row["origen"]; ?>
                    </td>
                    <td width="10%" align="center">
                        <?php echo nombreComuna($row["comuna"]); ?>
                    </td>
                    <td width="10%" align="center">
                        <?php echo nombreUsuario($row["id_usuario"]); ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>

</div>