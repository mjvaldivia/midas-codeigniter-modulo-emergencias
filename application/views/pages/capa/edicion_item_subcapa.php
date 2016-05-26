<form class="form-horizontal" role="form">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table">
                        <tr>
                            <td>Capa</td><td class="text-right"><strong><?php echo $capa?></strong></td>
                        </tr>
                        <tr>
                            <td>Sub capa</td><td class="text-right text-bold"><strong><?php echo $subcapa?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    
                </div>
            </div>
            <div class="row">
            <?php if($id_item == 0):?>
                <div class="col-xs-12">
                    <label for="nombre_lugar" class="control-label">Dirección/Ubicación del item:</label>
                    <input  class="form-control" name="nombre_lugar_item" id="nombre_lugar_item" />
                </div>
            <?php endif;?>
                <div class="col-xs-12">
                    <div id="mapa" class="top-spaced mapa-alarma" style="height: 500px !important;"></div>
                </div>
            </div>
            <?php if(isset($tipo) and $tipo == "Point"):?>
            <div class="row">
                <div class="col-xs-6">
                    Latitud:
                    <input type="text" name="latitud" id="latitud" value="<?php echo $latitud?>" class="form-control mapa-coordenadas" placeholder="longitud (e)" />
                </div>
                <div class="col-xs-6">
                    Longitud:
                    <input type="text" name="longitud" id="longitud" value="<?php echo $longitud?>" class="form-control mapa-coordenadas" placeholder="latitud (n)" />
                </div>
            </div>
            <?php elseif(isset($geometria) and $geometria["type"] == "Point"):?>
            <div class="row">
                <div class="col-xs-6">
                    Latitud:
                    <input type="text" name="latitud" id="latitud" value="<?php echo $latitud?>" class="form-control mapa-coordenadas" />
                </div>
                <div class="col-xs-6">
                    Longitud:
                    <input type="text" name="longitud" id="longitud" value="<?php echo $longitud?>" class="form-control mapa-coordenadas" />
                </div>
            </div>    
            <?php endif;?>
           
        </div>
        <div class="col-xs-12 col-md-6">
            <input type="hidden" name="id_subcapa" id="id_subcapa" value="<?php echo $id_subcapa?>" />
            <input type="hidden" name="id_item" id="id_item" value="<?php echo $id_item?>" />
            <table class="table table-hover table-condensed table-stripped table-bordered small">
                <thead>
                <tr>
                    <th class="text-center">Propiedad</th>
                    <th class="text-center">Valor</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($propiedades as $key=>$value):?>
                    <tr>
                        <td class="text-center">
                            <label class="control-label col-xs-12"><?php echo $key?></label>
                        </td>
                        <td class="text-center">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="hidden" name="propiedad_nombre[]" value="<?php echo $key?>" class="form-control" />
                                    <input type="text" name="propiedad_valor[]"  value="<?php echo $value?>" class="form-control propiedad_valores" />
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <div class="top-spaced text-right">
                <button class="btn btn-square btn-primary" type="button" onclick="xModal.close();">Cerrar</button>
                <button class="btn btn-square btn-success" type="button" onclick="Layer.guardarItemSubcapa(this.form, this, <?php echo $id_item?>);">Guardar</button>
            </div>
        </div>
    </div>
</form>

<?php echo $js?>
<?= loadJS("assets/js/modulo/mapa/formulario.js"); ?>
<?= loadJS("assets/js/modulo/capa/item/editar.js"); ?>
<?php if($id_item == 0):?>
<script type="text/javascript">
bindMapa();
</script>
<?php endif;?>

