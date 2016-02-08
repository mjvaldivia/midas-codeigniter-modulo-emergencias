<div class="col-xs-9">
    <div class="tab-content">
        <?php $active = "active"; ?>
        <?php foreach($lista_capas as $id_capa => $capa){ ?>
        <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="capa_<?php echo $prefix; ?>_<?php echo $id_capa; ?>">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive" data-row="5" style="width:100%">
                        <table class="table table-hover table-letra-pequena datatable paginada">
                            <thead>
                                <tr>
                                <?php 
                                    $columnas = reset($capa["marcadores"]);
                                    foreach($columnas->informacion as $key => $void){
                                ?>
                                    <th><?php echo $key; ?></th>
                                <?php } ?>    
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach($capa["marcadores"] as $marcador) { ?>
                            <tr>
                                <?php foreach($columnas->informacion as $key => $void){ ?>
                                <td><?php echo $marcador->informacion->$key ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $active = ""; ?>
        <?php } ?>
        
         <?php if(count($lista_otros)>0) { ?>
        <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="otros_<?php echo $prefix; ?>">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive" data-row="5" style="width:100%">
                        <table class="table table-hover table-letra-pequena datatable paginada">
                            <thead>
                                <tr>
                                <?php 
                                    $columnas = reset($lista_otros);
                                    foreach($columnas->informacion as $key => $void){
                                ?>
                                    <th><?php echo $key; ?></th>
                                <?php } ?>    
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach($lista_otros as $marcador) { ?>
                            <tr>
                                <?php foreach($columnas->informacion as $key => $void){ ?>
                                <td><?php if(isset($marcador->informacion->$key)) { echo $marcador->informacion->$key; } ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>