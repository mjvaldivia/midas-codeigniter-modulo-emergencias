<div class="col-lg-12" data-row="5">
    <table id="grilla-alarmas" class="table table-striped datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <th>Nombre alarma</th>
                <th>Tipo alarma</th>
                <th>Comunas afectadas</th>
                <th>Fecha alarma</th>
                <th>Lugar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td width="5%" class="text-center">
                    <?php echo htmlIconoEmergenciaTipo($row["tip_ia_id"]); ?>
                </td>
                <td>
                    <?php echo $row["ala_c_nombre_emergencia"]; ?>
                </td>
                <td>
                    <?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> 
                </td>
                <td> 
                    <?php echo textMoreLess(comunasAlarmaConComa($row["ala_ia_id"])); ?>
                </td>
                <td>
                    <?php echo ISODateTospanish($row["ala_d_fecha_emergencia"]); ?>
                </td>
                <td>
                    <?php echo textMoreLess($row["ala_c_lugar_emergencia"]); ?>
                </td>
                <td width="80px" class="text-center">
                    <!--<button onclick="javascript:formEditarAlarma(<?php echo $row["ala_ia_id"]; ?>)" class="btn btn-xs btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Editar la alarma">
                        <i class="fa fa-edit"></i>
                    </button>-->
                    <?php if (puedeEditar("emergencia")) { ?>
                    <button data="<?php echo $row["ala_ia_id"]; ?>" class="btn btn-xs btn-blue emergencia-nueva" data-toggle="tooltip" data-toogle-param="arriba" title="Generar emergencia">
                        <i class="fa fa-bullhorn"></i>
                    </button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>