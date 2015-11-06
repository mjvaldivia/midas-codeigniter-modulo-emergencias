

<div class="row">
    
    <div class="col-xs-12">
        <div class="page-title">
            <h1>Soportes
                <small><i class="fa fa-arrow-right"></i> Tickets de Soporte</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-question-circle"></i> Soportes</li>
                <li>Tickets usuarios</li>
            </ol>
        </div>
        <h3 class="page-header">
            Bandeja Soportes
            
        </h3>
    </div>

    <div class="table-responsive col-xs-12 small" id="contenedor-tabla-soportes">
        <table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($soportes as $item):?>
                <tr>
                    <td class="text-center"><?php echo $item->soporte_codigo?></td>
                    <td class="text-center"><?php echo $item->soporte_fecha_ingreso?></td>
                    <td class="text-center"><?php echo $item->soporte_asunto?></td>
                    <td class="text-center"><?php echo mb_strtoupper($item->nombre_usuario)?></td>
                    <td class="text-center"><?php echo $item->estado?>
                        <?php if($item->no_leidos > 0):?>
                        <label class="label label-info">Nuevo mensaje</label>    
                        <?php endif;?>
                    </td>
                    <td class="text-center">
                        <?php $url = site_url('soportes/verSoporte/id/'.$item->soporte_id);?>
                        <a data-toggle="modal" class='btn btn-primary btn-xs modal-sipresa' href="<?php echo $url?>" data-title="Información de la actividad" data-success='' data-target="#modal_ver_soporte"><i class="fa fa-search-plus"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>    
        </table>
    </div>

</div>


<!-- <div class="modal fade" id="modal_nuevo_soporte" role="dialog" aria-hidden="true"></div> -->




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