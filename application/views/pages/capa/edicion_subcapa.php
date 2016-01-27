<div class="portlet portlet-default">
    <div class="portlet-heading">
        <div class="portlet-title"><h4>Editando Sub Capa <?php echo $capa['geometria_nombre']?></h4></div>
    </div>
    <div class="portlet-body">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form">
                <input type="hidden" name="id_subcapa" id="id_subcapa" value="<?php echo $capa['geometria_id']?>" />
                <input type="hidden" name="id_capa" id="id_capa" value="<?php echo $capa['geometria_capa']?>" />
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Tipo/Nombre</label>
                    <div class="col-md-6 col-xs-12">
                        <input type="text" class="form-control" name="nombre_subcapa" id="nombre_subcapa" value="<?php echo $capa['geometria_nombre']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Capa</label>
                    <div class="col-xs-12 col-md-6">
                        <p class="form-control-static"><?php echo $capa['cap_c_nombre']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Icono/Color</label>
                    <div class="col-xs-1 col-md-1 text-center" id="contenedor-icono">

                        <?php if($capa['geometria_icono'] != ""):?>
                            <?php if($capa['geometria_tipo'] == 1):?>
                            <img src="<?php echo base_url($capa['geometria_icono'])?>" />
                            <?php else:?>
                            <div class="color-capa-preview" style="background-color:<?php echo $capa['geometria_icono']?>"></div>
                            <?php endif;?>
                        <?php else:?>
                            <?php echo getCapaPreview($capa["cap_ia_id"]);?>
                        <?php endif;?>

                    </div>
                    <div class="col-xs-11 col-md-4">
                        <?php if($capa['geometria_tipo'] == 1):?>
                            <input type="file" name="input_icono_subcapa" id="input_icono_subcapa" data-show-preview="false" />
                            <input type="hidden" name="tmp_file_icono" id="tmp_file_icono" />
                            <input type="hidden" name="ruta_icono" id="ruta_icono" />
                        <?php else:?>
                            <input name="color_poligono" id="color_poligono" placeholder="Color del poligono o linea" type='text' class="colorpicker required" value=""/>
                        <?php endif;?>

                    </div>
                </div>

                <div class="col-md-10 text-right">
                    <button type="button" class="btn btn-green btn-square" onclick="Layer.guardarSubCapa(this.form,this);">Guardar</button>
                    <button type="button" class="btn btn-default btn-square" onclick="Layer.cancelarEdicion();">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#input_icono_subcapa").fileinput({
            language: "es",
            multiple: false,
            uploadAsync: false,
            initialCaption: "Seleccione icono para la subcapa",
            uploadUrl: siteUrl + "capas/subir_CapaIconTemp"
        });

        $('#input_icono_subcapa').on('fileloaded', function(event, file){
            $(this).fileinput("upload");
        });

        $('#input_icono_subcapa').on('filebatchuploadsuccess', function(event, data) {
            var ruta = data.response.ruta;
            var icono = $("#contenedor-icono > img")
            icono.attr('src',ruta);
            $("#ruta_icono").val(ruta);
            $("#tmp_file_icono").val(data.response.nombre_cache_id);
        });
    })

</script>