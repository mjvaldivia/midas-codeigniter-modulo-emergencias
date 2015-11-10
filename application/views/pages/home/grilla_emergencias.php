<div class="col-lg-12" data-row="5">
    <table id="grilla-emergencia" class="table table-striped datatable paginada hidden">
        <thead>
            <tr>
                <th></th>
                <th>Nombre emergencia</th>
                <th>Tipo emergencia</th>
                <th>Comunas afectadas</th>
                <th>Fecha emergencia</th>
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
                <td><?php echo $row["eme_c_nombre_informante"]; ?></td>
                <td><?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> </td>
                <td>
                   
                    <?php echo textMoreLess(comunasEmergenciaConComa($row["eme_ia_id"])); ?>
                   
                </td>
                <td><?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?></td>
                <td><?php echo $row["eme_c_lugar_emergencia"]; ?></td>
                <td>
                    <button onclick="window.open(siteUrl + 'emergencia/editar/id/<?php echo $row["eme_ia_id"]; ?>', '_blank');" class="btn btn-square btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Editar la emergencia">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button onclick="window.open(siteUrl + 'visor/index/id/<?php echo $row["eme_ia_id"]; ?>', '_blank');" class="btn btn-square btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Abrir el visor">
                        <i class="fa fa-globe"></i>
                    </button>
                    <button onclick="window.open(siteUrl + 'visor/reporte/id/<?php echo $row["eme_ia_id"]; ?>/ala_ia_id/<?php echo $row["ala_ia_id"] ?>', '_blank');" class="btn btn-square btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Ver reporte">
                        <i class="fa fa-file-text-o"></i>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>