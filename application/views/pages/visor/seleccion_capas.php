<?php if(count($lista_capas)>0){ ?>
    <?php foreach($lista_capas as $capa){ ?>
        <li id="<?php echo $capa["cap_ia_id"]; ?>" class="ui-state-default">
            
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-sort"></i>
                    </div>
                    <div class="col-xs-10">
                
                        <div class="row">
                            <div class="col-xs-2">
                                <input type="checkbox" id="chk_<?php echo $capa["cap_ia_id"]; ?>" name="chk_<?php echo $capa["cap_ia_id"]; ?>" onclick="VisorMapa.selectCapa(<?php echo $capa["cap_ia_id"]; ?>);" />
                            </div>
                            <div class="col-xs-2">
                                <?php echo getCapaPreview($capa["cap_ia_id"]); ?>
                            </div>
                            <div class="col-xs-8">
                                <div style="margin-left:3px">
                                    <?php echo $capa["cap_c_nombre"]; ?>
                                </div>
                            </div>
                        </div>
          
                    </div>
                </div>
       
        </li>  
    <?php } ?>
<?php } ?>


