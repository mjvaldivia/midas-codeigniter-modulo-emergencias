<div class="col-xs-3">
   <ul class="nav nav-pills tabs-left" role="tablist">
       <?php $active = "active"; ?>
       <?php foreach($lista_capas as $id_capa => $capa){ ?>
        <li role="presentation" class="<?php echo $active; ?>">
            <a href="#capa_<?php echo $id_capa; ?>" aria-controls="capa_<?php echo $id_capa; ?>" role="tab" data-toggle="tab">
                <?php echo $capa["preview"] . " " . $capa["nombre"]; ?>
            </a>
        </li>
        <?php echo $active = ""; ?>
       <?php } ?>
        
        <?php if(count($lista_otros)>0) { ?>
        <li role="presentation" class="<?php echo $active; ?>">
            <a href="#otros" aria-controls="otros" role="tab" data-toggle="tab">
                <i class="fa fa-question-circle"></i> Otros
            </a>
        </li>
        <?php } ?>
   </ul>
</div>