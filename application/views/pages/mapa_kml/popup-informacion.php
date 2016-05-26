<div class="col-lg-12">
    <div class="row">
        <input type="hidden" name="archivo_id" id="archivo_id" value="<?php echo $id; ?>" />
        <input type="hidden" name="archivo_hash" id="archivo_hash" value="<?php echo $hash; ?>" />
        
        <div id="elementos-eliminados" class="hidden">
            
        </div>
        
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h4>
                        <div class="pull-left">
                            <small><i class="fa fa-info-circle"></i> Información del archivo cargado</small>
                        </div>


                        <div class="clearfix"></div>
                    </h4>
                    <div class="tile dark-blue">
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>NOMBRE:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $nombre ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>ARCHIVO:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $archivo ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 text-right"><strong>TIPO:</strong></div>
                            <div class="col-lg-8 text-left"><?php echo $tipo ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="col-lg-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#instalaciones" aria-controls="instalaciones" role="tab" data-toggle="tab">
                        <i class="fa fa-map-marker"></i> Marcadores <div class="badge"></div>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#zonas" aria-controls="zonas" role="tab" data-toggle="tab">
                        <i class="fa fa-object-group"></i> Zonas <div class="badge"></div>
                    </a>
                </li>

            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="instalaciones">
                    <table class="table table-hover datatable paginada">
                        <thead>
                            <tr>
                                <th>Icono</th>
                                <th>Propiedades</th>
                                <th>Coordenadas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($puntos)>0) { ?>
                        <?php foreach($puntos as $row) { ?>
                            <tr>
                                <td>
                                    <img src="<?php echo base_url($row["icono"]) ?>" />
                                </td>
                                <td>
                                    <?php echo $row["propiedades"] ;?>
                                </td>
                                <td></td>
                                <td width="10%">
                                    <!--<button data-tipo="marcador" data-rel="<?php echo $row["id"] ;?>" class="btn btn-danger btn-xs archivo-eliminar-elemento"> <i class="fa fa-remove"></i> Eliminar </button>-->
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="zonas">
                   <table class="table table-hover datatable paginada">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tipo</th>
                                <th>Propiedades</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($zonas)>0) { ?>
                        <?php foreach($zonas as $row) { ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td>
                                    <?php echo $row["tipo"] ;?>
                                </td>
                                <td>
                                    <?php echo $row["propiedades"] ;?>
                                </td>
                                <td width="10%">
                                    <!--<button data-tipo="poligono" data-rel="<?php echo $row["id"] ;?>" class="btn btn-danger btn-xs archivo-eliminar-elemento"> <i class="fa fa-remove"></i> Eliminar </button>-->
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
        </div>
        
    </div>
</div>
<div class="clearfix"></div>

