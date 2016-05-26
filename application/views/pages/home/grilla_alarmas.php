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
                <td width="10%" align="center">
                    <div style="width: 220px">
                        <div class="row">
                            <?php if(permisoEvento("bitacora")) { ?>
                                <button title="Bitácora" class="btn btn-sm btn-primary" type="button" onclick="xModal.open('<?php echo base_url('evento/expediente/id/'.$row['eme_ia_id'])?>','Bitácora',75);">
                                    <i class="fa fa-files-o"></i>
                                </button>
                            <?php } ?>
                            <?php if (permisoEvento("editar")) { ?>
                                <button title="Editar" class="btn btn-sm btn-success emergencia-editar" type="button"  data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-editar" href="#">
                                    <i class="fa fa-edit"></i>
                                </button>
                            <?php } ?>
                            <?php if (permisoEvento("editar")) { ?>
                                <button title="Documentos" class="btn btn-sm btn-white" type="button" onclick="window.open(baseUrl + 'evento_documentos/index/id/<?php echo $row["eme_ia_id"]; ?>', '_self');"  data="<?php echo $row["eme_ia_id"] ?>" class="emergencia-editar" href="#">
                                    <i class="fa fa-file"></i>
                                </button>
                            <?php } ?>
                            <?php if(permisoEvento("visor")) { ?>
                                <button title="Abrir visor" class="btn btn-sm btn-default" type="button"  onclick="window.open(baseUrl + 'mapa/index/id/<?php echo $row["eme_ia_id"]; ?>', '_self');" href="#">
                                    <i class="fa fa-globe"></i> 
                                </button>
                            <?php } ?>
                            <?php if (permisoEvento("activar")) { ?>
                                    <a data="<?php echo $row["eme_ia_id"]; ?>" class="emergencia-nueva btn btn-sm btn-purple" href="#">
                                        <i class="fa fa-bullhorn"></i>
                                    </a>
                            <?php } ?>
                            <?php if (permisoEvento("eliminar")) { ?>
                                    <a data="<?php echo $row["eme_ia_id"]; ?>" class="alarma-eliminar btn btn-sm btn-danger" href="#">
                                        <i class="fa fa-trash"></i>
                                    </a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
                
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>