<div data-row="100">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
        <tr>
            <th>Opciones</th>
            <th>N° de acta</th>
            <th>Fecha toma de muestra</th>
            <th>Laboratorio</th>
            <th>Resultado</th>
            <th>Estado</th>
            <th>Validado</th>
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
                    <td align="left" width="10%">
                        <div style="width: 150px">
                            <?php if (permisoMareaRoja("editar")) { ?>
                                <button data-rel="<?php echo $row["id"]; ?>" title="Ingresar resultados" class="btn btn-sm btn-success editar-marea-roja" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php } ?>

                            <?php if (permisoMareaRoja("validar")) { ?>
                                <?php echo mareaRojaBotonValidar($row['id'], $row["bo_ingreso_resultado"], $row["bo_validado"]); ?>
                            <?php } ?>

                            <?php echo mareaRojaBotonVerActa($row['id'], $row['numero_muestra']); ?>
                        
                        </div>
                    </td>
                    <td width="5%" align="center">
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
                        <?php echo mareaRojaEstadoResultado($row["resultado"], $row["bo_ingreso_resultado"]); ?>
                    </td>
                    <td width="10%">
                        <?php echo mareaRojaEstadoValidado($row["bo_ingreso_resultado"], $row["bo_validado"]); ?>
                    </td>
                    <td width="10%">
                        <?php echo $row["recurso"]; ?>
                    </td>
                    <td width="15%">
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