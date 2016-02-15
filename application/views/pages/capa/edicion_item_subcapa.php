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
                <div class="col-xs-12">
                    <div id="mapa" class="top-spaced mapa-alarma" style="height: 500px !important;"></div>
                </div>
            </div>
            <div class="row <?php if($geometria["type"] != "Point") echo "hidden"; ?>">
                <div class="col-xs-6">
                    Latitud:
                    <input type="text" name="latitud" id="latitud" value="<?php echo $latitud?>" class="form-control" />
                </div>
                <div class="col-xs-6">
                    Longitud:
                    <input type="text" name="longitud" id="longitud" value="<?php echo $longitud?>" class="form-control" />
                </div>
            </div>
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
                                    <input type="text" name="propiedad_valor[]"  value="<?php echo $value?>" class="form-control" />
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <div class="top-spaced text-right">
                <button class="btn btn-square btn-primary" type="button" onclick="Layer.cancelarEdicionItem(<?php echo $id_subcapa?>);">Volver</button>
                <button class="btn btn-square btn-success" type="button" onclick="Layer.guardarItemSubcapa(this.form, this, <?php echo $id_item?>);">Guardar</button>
            </div>
        </div>
    </div>
</form>

<?php echo $js?>
<?= loadJS("assets/js/modulo/capa/item/editar.js"); ?>

