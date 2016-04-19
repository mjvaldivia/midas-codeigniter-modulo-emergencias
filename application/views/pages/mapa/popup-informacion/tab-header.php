<div class="col-xs-3">
   <ul class="nav nav-pills tabs-left" role="tablist">
       <?php $active = "active"; ?>
       <?php foreach($lista_capas as $id_capa => $capa){ ?>
        <li role="presentation" class="<?php echo $active; ?>">
            <a href="#capa_<?php echo $prefix; ?>_<?php echo $id_capa; ?>" aria-controls="capa_<?php echo $id_capa; ?>" role="tab" data-toggle="tab">
                <div class="row">
                <div class="col-xs-2"><?php echo $capa["preview"]; ?></div><div class="col-xs-10"><?php echo $capa["nombre"]; ?></div>
                </div>
            </a>
        </li>
        <?php echo $active = ""; ?>
       <?php } ?>
        
        <?php if(count($lista_otros)>0) { ?>
        <li role="presentation" class="<?php echo $active; ?>">
            <a href="#otros_<?php echo $prefix; ?>" aria-controls="otros" role="tab" data-toggle="tab">
                <div class="row">
                <div class="col-xs-2"><i class="fa fa-question-circle"></i></div><div class="col-xs-10"> Otros</div>
                </div>
            </a>
        </li>
        <?php } ?>
   </ul>
</div>