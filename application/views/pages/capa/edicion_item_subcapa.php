<div class="portlet portlet-default top-spaced">
    <div class="portlet-heading">
        <h4 class="portlet-title">Edición de Item de Subcapa</h4>
    </div>
    <div class="portlet-body">
        <div class="col-xs-12 col-md-6">
            <table class="table">
                <tr>
                    <td>Capa</td><td class="text-right"><strong><?php echo $capa?></strong></td>
                </tr>
                <tr>
                    <td>Sub capa</td><td class="text-right text-bold"><strong><?php echo $subcapa?></strong></td>
                </tr>
                <tr>
                    <td>Comuna</td><td class="text-right text-bold"><strong><?php echo $comuna?></strong></td>
                </tr>
            </table>
            <div id="mapa" class="top-spaced mapa-alarma" style="height: 400px !important;"></div>
        </div>
        <div class="col-xs-12 col-md-6">
            <input type="hidden" name="id_subcapa" id="id_subcapa" value="<?php echo $id_subcapa?>" />
            <form class="form-horizontal" role="form">
                <table class="table table-hover table-condensed table-stripped table-bordered">
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
                                        <input type="text" name="<?php echo $key?>" id="<?php echo $key?>" value="<?php echo $value?>" class="form-control" />
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
            </form>
        </div>
    </div>
</div>


<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/modulo/mapa/visor.js"); ?>
<?= loadJS("assets/js/modulo/mapa/capa.js"); ?>
<?= loadJS("assets/js/modulo/mapa/marcador.js"); ?>
<?= loadJS("assets/js/modulo/mapa/poligono.js"); ?>
<?= loadJS("assets/js/modulo/mapa/poligono/poligono_multi.js"); ?>
<script type="text/javascript">
    $(document).ready(function(){
        var visor = new Visor("mapa");


        var capas = new MapaCapa();
        //visor.addOnReadyFunction("capas asociadas a la emergencia", capas.addCapaPorId, 105);
        visor.addCapa(capas);

        visor.bindMapa();
    <?php if($geometria['type'] == 'Point'):?>
        var marcador = new MapaMarcador();
        marcador.posicionarMarcador(capas,<?php echo $geometria['coordinates'][0]?>,<?php echo $geometria['coordinates'][1]?>,'','19H','');
    <?php endif;?>

        //recargar mapa al abrir o cerrar menu
        $("#sidebar-toggle").click(function(){
            visor.resizeMap();
        });
    });

</script>