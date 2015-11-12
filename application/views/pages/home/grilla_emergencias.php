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
                <td><?php echo textMoreLess($row["eme_c_nombre_emergencia"]); ?></td>
                <td><?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> </td>
                <td>
                    <?php echo textMoreLess(comunasEmergenciaConComa($row["eme_ia_id"])); ?>
                </td>
                <td><?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?></td>
                <td><?php echo textMoreLess($row["eme_c_lugar_emergencia"]); ?></td>
                <td width="80px">
                    
                    <!--<button data-style='width:80%;' class="btn btn-xs btn-blue modal-sipresa" data-href="<?= site_url("visor/reporte/id/" .  $row["eme_ia_id"] . "/ala_ia_id/" . $row["ala_ia_id"]); ?>" data-title='Administracion del Reporte' data-success='exportarMapa(<?php echo $row["ala_ia_id"] ?>);' data-target='#modal_<?php echo $row["ala_ia_id"] ?>'>
                        <i class="fa fa-fa2x fa-file-text-o"></i>
                    </button>-->
                    
                    <?php if (puedeEditar()) { ?>
                    <button data="<?php echo $row["eme_ia_id"] ?>" class="btn btn-xs btn-blue emergencia-editar" data-toggle="tooltip" data-toogle-param="arriba" title="Editar la emergencia">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    
                    <button onclick="window.open(siteUrl + 'visor/index/id/<?php echo $row["eme_ia_id"]; ?>', '_blank');" class="btn btn-xs btn-blue" data-toggle="tooltip" data-toogle-param="arriba" title="Abrir el visor">
                        <i class="fa fa-globe"></i>
                    </button>
                    
                    <?php if (puedeEditar()) { ?>
                    <button data="<?php echo $row["eme_ia_id"] ?>" class="btn btn-xs btn-blue emergencia-cerrar" data-toggle="tooltip" data-toogle-param="arriba" title="Cerrar emergencia">
                        <i class="fa fa-check"></i>
                    </button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>