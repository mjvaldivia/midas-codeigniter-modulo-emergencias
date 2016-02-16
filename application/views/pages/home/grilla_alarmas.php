<div class="col-lg-12" data-row="5">
    <table id="grilla-alarmas" class="table table-hover datatable paginada hidden">
        <thead>
            <tr>
                <th>Nombre Evento</th>
                <th>Tipo Evento</th>
                <th>Comunas afectadas</th>
                <th>Fecha Evento</th>
                <th>Lugar</th>
                <th width="5%">Opciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($lista)>0){ ?>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td>
                    <?php echo $row["eme_c_nombre_emergencia"]; ?>
                </td>
                <td>
                    <?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> 
                </td>
                <td> 
                    <?php echo textMoreLess(comunasAlarmaConComa($row["eme_ia_id"])); ?>
                </td>
                <td>
                    <?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?>
                </td>
                <td>
                    <?php echo textMoreLess($row["eme_c_lugar_emergencia"]); ?>
                </td>
                <td class="text-right">
                    <?php if (puedeActivarAlarma("alarma")) { ?>
                            <a data="<?php echo $row["eme_ia_id"]; ?>" class="emergencia-nueva btn btn-sm btn-purple" href="#">
                                <i class="fa fa-bullhorn"></i>
                            </a>
                    <?php } ?>
                    <?php if (puedeEliminar("alarma")) { ?>
                            <a data="<?php echo $row["eme_ia_id"]; ?>" class="alarma-eliminar btn btn-sm btn-danger" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                    <?php } ?>
                </td>
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>