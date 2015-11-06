
<div class="col-xs-12">
    <div class="well">
        <h3 class="">Soporte <?php echo $soporte->soporte_codigo?></h3>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <p><?php echo $soporte->soporte_asunto?></p>
                <p class="small"><?php echo $soporte_mensaje->soportemensaje_texto?></p>
                <?php if(count($adjuntos_principal) > 0):?>
                <ul class="small" style="list-style: none">
                    <?php foreach($adjuntos_principal as $item):?>
                    <?php $url = site_url('soportes/verAdjunto/token/'.$item['sha']);?>
                    <li><a href="<?php echo $url?>" target="_blank" style="color:#eee"><i class="fa fa-file"></i>  <?php echo $item['nombre']?></a></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <div class="small text-right">Enviado por <?php echo $soporte->nombre_usuario?>, el <?php echo $soporte->soporte_fecha_ingreso?></div>
            </div>
        </div>
        <div class="list-group">
            <?php foreach($mensajes as $mensaje):?>
            <?php if($soporte->soporte_usuario_fk == $mensaje->soportemensaje_usuario_fk):?>
                <?php $textAlign = 'text-left alert alert-warning';?>
            <?php else:?>
                <?php $textAlign = 'text-right alert alert-info';?>
            <?php endif;?>
            <div class="list-group-item <?php echo $textAlign;?>" style="overflow: hidden">    
                <p class="list-group-item-text small"><?php echo $mensaje->soportemensaje_texto?></p>
                <?php if(isset($adjuntos_mensajes[$mensaje->soportemensaje_id]) and count($adjuntos_mensajes[$mensaje->soportemensaje_id]) > 0):?>
                <ul class="small" style="list-style: none">
                    <?php foreach($adjuntos_mensajes[$mensaje->soportemensaje_id] as $item):?>
                    <?php $url = site_url('soportes/verAdjunto/token/'.$item['sha']);?>
                    <li><a href="<?php echo $url?>" target="_blank" ><i class="fa fa-file"></i>  <?php echo $item['nombre']?></a></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <span class="small" style="font-size:10px; font-style:italic;border-top:1px solid #ccc;display:block;margin-top:5px;">Enviado por <?php echo mb_strtoupper($mensaje->nombre_usuario)?>, el <?php echo $mensaje->soportemensaje_fecha?></span>
            </div>
            <?php endforeach;?>
        </div>
        <div class="text-center">
            <a class="btn btn-default" href="javascript:void(0);" onclick="ModalSipresa.close_modal('modal_ver_soporte')">Cerrar Ventana</a>
            <?php if($soporte->soporte_estado != 3):?>
            <?php $url = site_url('soportes/nuevoMensaje/id/'.$soporte->soporte_id);?>
            <a data-toggle="modal" class='btn btn-success modal-sipresa' href="<?php echo $url?>" data-title="" data-success='' data-target="#modal_nuevo_mensaje">Nuevo Mensaje</a>

            <?php if($cerrar_ticket):?>
            <a class="btn btn-primary" type="button" href="javascript:void(0);" onclick="Soportes.cerrarTicket(<?php echo $soporte->soporte_id?>,'<?php echo $soporte->soporte_codigo?>');">Cerrar Ticket</a>
            <?php endif;?>
            <?php endif;?>
        </div>
    </div>
</div>