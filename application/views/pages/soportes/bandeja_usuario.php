 
<div class="row">

    
    <div class="col-xs-12">
        <div class="page-title">
            <h1>Mesa de Ayuda
                <small><i class="fa fa-arrow-right"></i> Tickets de Soporte</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-question-circle"></i> Mesa de ayuda</li>
                <li>Soportes</li>
            </ol>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Bandeja de Soportes</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body clearfix">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#tickets_ingresados" data-toggle="tab">
                            Tickets Ingresados  
                            <button type="button" data-toggle="modal" class='btn btn-primary pull-right modal-sipresa btn-xs btn-square' href="<?php echo site_url('soportes/nuevoSoporte')?>" data-title="Nuevo Ticket" data-success='' data-target="#modal_nuevo_soporte" style="margin-left:5px;"><i class="fa fa-send-o"></i> Nuevo Ticket</button>
                        </a> 
                    </li>
                    <li class=""><a href="#tickets_cerrados" data-toggle="tab">Tickets Cerrados</a></li>
                </ul>
                    
                <div id="myTabContent" class="tab-content">

                    <!-- tab tickets ingresados -->
                    <div class="tab-pane fade active in" id="tickets_ingresados">
                        <div id="contenedor-tabla-soportes" class="small">
                            <table class="table table-hover table-condensed table-bordered table-middle" id="tabla_soportes">
                                <thead>
                                    <tr>
                                        <th># Ticket</th>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <!-- <th>Enviado por</th> -->
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($soportes_ingresados as $item):?>
                                    <tr>
                                        <td class="text-center"><?php echo $item->soporte_codigo?></td>
                                        <td class="text-center"><?php echo $item->soporte_fecha_ingreso?></td>
                                        <td class="text-center"><?php echo $item->soporte_asunto?></td>
                                        <!-- <td class="text-center"><?php echo mb_strtoupper($item->nombre_usuario)?></td> -->
                                        <td class="text-center"><?php echo $item->estado?>
                                            <?php if($item->no_leidos > 0):?>
                                            <label class="label label-info">Nuevo mensaje</label>    
                                            <?php endif;?>
                                        </td>
                                        <td class="text-center">
                                            <?php $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);?>
                                            <a data-toggle="modal" class='btn btn-blue btn-xs modal-sipresa btn-square' href="<?php echo $url?>" data-title="Información de la actividad" data-success='' data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>    
                            </table>
                        </div>
                    </div> <!-- fin tabs tickets ingresados -->

                    <!-- tab tickets cerrados -->
                    <div class="tab-pane fade" id="tickets_cerrados">
                        <div id="contenedor-tabla-soportes-cerrados" class="small">
                            <table class="table table-hover table-condensed table-bordered table-middle" id="tabla_soportes_cerrados">
                                <thead>
                                    <tr>
                                        <th># Ticket</th>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Fecha Cierre</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($soportes_cerrados as $item):?>
                                    <tr>
                                        <td class="text-center"><?php echo $item->soporte_codigo?></td>
                                        <td class="text-center"><?php echo $item->soporte_fecha_ingreso?></td>
                                        <td class="text-center"><?php echo $item->soporte_asunto?></td>
                                        <td class="text-center"><?php echo $item->estado?></td>
                                        <td class="text-center"><?php echo $item->soporte_fecha_cierre?></td>
                                        <td class="text-center">
                                            <?php $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);?>
                                            <a data-toggle="modal" class='btn btn-blue btn-xs modal-sipresa btn-square' href="<?php echo $url?>" data-title="Información de la actividad" data-success='' data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>    
                            </table>
                        </div>
                    </div> <!-- fin tab tickets cerrados -->
                </div>

            </div>
        </div>
    </div>


    

</div>



<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/bootbox.min.js") ?>

<?= loadJS("assets/js/soportes.js") ?>


<script type="text/javascript">
    $(document).ready(function () {
        Soportes.init();
        
    });
</script>