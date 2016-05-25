<div data-row="100">
    <table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
        <thead>
        <tr>
            <th>Código</th>
            <th>N° de acta</th>
            <th width="10%">Fecha ingreso</th>
            <th width="10%">Fecha toma de muestra</th>
            <th width="10%">Laboratorio</th>
            <th width="10%">Resultado</th>
            <th width="15%">Estado</th>
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