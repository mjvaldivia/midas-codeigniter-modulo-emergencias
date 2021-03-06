<div data-row="100">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
        <tr>
            <th>Opciones</th>
            <th>Código</th>
            <th>N° de acta</th>
            <th>Fecha ingreso</th>
            <th>Fecha toma de muestra</th>
            <th>Laboratorio</th>
            <th>Resultado</th>
            <th>Estado</th>
            <th>Recurso</th>
            <th>Origen</th>
            <th>Comuna</th>
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
                                <button <?php if($row["id_laboratorio"] != "") { ?> disabled <?php } ?> data-rel="<?php echo $row["id"]; ?>" title="Ingresar muestra" class="btn btn-sm btn-success editar-marea-roja" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php } ?>

                           <!-- <?php if (permisoMareaRoja("eliminar")) { ?>
                                <button <?php if($row["id_laboratorio"] != "") { ?> disabled <?php } ?>  title="Eliminar" class="btn btn-sm btn-red caso-eliminar" type="button"
                                        data="<?php echo $row["id"] ?>" href="#">
                                    <i class="fa fa-trash"></i>
                                </button>
                            <?php } ?> -->
                            
                            <button type="button" class="btn btn-sm btn-primary adjuntar-acta" title="Adjuntar Acta" data-muestra="<?php echo $row['id'] ?>" data-acta="<?php echo $row['numero_muestra'] ?>">
                                <i class="fa fa-upload"></i>
                            </button>
                            
                            <?php echo mareaRojaBotonVerActa($row['id'], $row['numero_muestra']); ?>
     
                        </div>
                    </td>
                    
                    <td width="10%">
                        Muestreo N°<?php echo $row["id"]; ?>
                    </td>
                    
                    <td width="10%" align="center">
                        <?php echo $row["numero_muestra"]; ?>
                    </td>
                    
                    <td width="10%">
                        <?php echo $row["fecha_ingreso"]; ?>
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

                    <td width="20%">
                        <?php echo mareaRojaEstadoResultado($row["resultado"], $row["bo_ingreso_resultado"]); ?>
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