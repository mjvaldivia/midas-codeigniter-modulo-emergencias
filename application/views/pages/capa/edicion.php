
<div class="portlet portlet-green">
    <div class="portlet-heading">
        <div class="portlet-title"><h4>Editando capa</h4></div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" id="form_capas_edicion">
            <input type="hidden" name="capa_edicion" id="capa_edicion" value="<?php echo $capa->cap_ia_id?>" />
            <div class="form-group">
                <label class="col-md-3 control-label">Nombre (*)</label>
                <div class="col-md-9">
                    <input type="text" id="nombre_editar" name="nombre_editar" class="form-control required" placeholder="Nombre de la(s) Capa(s)" value="<?php echo $capa->cap_c_nombre?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Categoría (*)</label>
                <div class="col-md-7">
                    <select id="iCategoria_editar" name="iCategoria_editar" class="form-control required" placeholder="Categoría de la Capa">
                        <?php foreach($categorias as $categoria):?>
                        <option value="<?php echo $categoria['categoria_id']?>" <?php if($capa->ccb_ia_categoria == $categoria['categoria_id']):?> selected <?php endif;?> ><?php echo $categoria['categoria_nombre']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <?php if($capa->color != ""){ ?>
            <div class="form-group">
                <label class="col-md-3 control-label">Color (*)</label>
                <div class="col-md-7">
                    <input name="color_editar" id="color_editar" placeholder="Color del poligono" type='text' class="colorpicker required" value="<?php echo $capa->color; ?>"/>
                </div>
            </div>
            <?php } ?>
            
            <?php if($capa->icon_path != ""){ ?>
            <div class="form-group">
                <label class="col-md-3 control-label">Icono (*)</label>
                <div class="col-md-7">
                    <select name="icono_editar" id="icono_editar" style="width: 300px" placeholder="Icono de los marcadores" class="select2-images required">
                        <option value=""></option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi.png") ?>">Rojo</option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi-yellow.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi-yellow.png") ?>">Amarillo</option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi-blue.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi-blue.png") ?>">Azul</option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi-green.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi-green.png") ?>">Verde</option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi-pink.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi-pink.png") ?>">Rosado</option>
                        <option <?php if($capa->icon_path == "assets/img/markers/spotlight-poi-black.png"):?> selected <?php endif;?> value="<?php echo base_url("assets/img/markers/spotlight-poi-black.png") ?>">Negro</option>
                    </select>
                </div>
            </div>
            <?php } ?>
            
            <!--<div class="form-group">
                <label class="col-md-3 control-label">Zona Geográfica (*)</label>
                <div class="col-md-7 row">
                    <div class="col-md-2" style="min-width:10%">
                    
                   <select id="gznumber_editar" name="gznumber_editar" class="form-control">
                        <option value="12" <?php /*if($capa->cap_c_geozone_number == 12):*/?> selected <?php /*endif;*/?> >12</option>
                        <option value="13" <?php /*if($capa->cap_c_geozone_number == 13):*/?> selected <?php /*endif;*/?> >13</option>
                        <option value="14" <?php /*if($capa->cap_c_geozone_number == 14):*/?> selected <?php /*endif;*/?> >14</option>
                        <option value="15" <?php /*if($capa->cap_c_geozone_number == 15):*/?> selected <?php /*endif;*/?> >15</option>
                        <option value="16" <?php /*if($capa->cap_c_geozone_number == 16):*/?> selected <?php /*endif;*/?> >16</option>
                        <option value="17" <?php /*if($capa->cap_c_geozone_number == 17):*/?> selected <?php /*endif;*/?> >17</option>
                        <option value="18" <?php /*if($capa->cap_c_geozone_number == 18):*/?> selected <?php /*endif;*/?> >18</option>
                        <option value="19" <?php /*if($capa->cap_c_geozone_number == 19):*/?> selected <?php /*endif;*/?> >19</option>
                        <option value="20" <?php /*if($capa->cap_c_geozone_number == 20):*/?> selected <?php /*endif;*/?> >20</option>
                    </select>
                </div>
                  <div class="col-md-1" style="min-width:15%">  
                    <select id="gzletter" name="gzletter" class="form-control">
                        <option value="C" <?php /*if($capa->cap_c_geozone_letter == 'C'):*/?> selected <?php /*endif;*/?> >C</option>
                        <option value="D" <?php /*if($capa->cap_c_geozone_letter == 'D'):*/?> selected <?php /*endif;*/?> >D</option>
                        <option value="E" <?php /*if($capa->cap_c_geozone_letter == 'E'):*/?> selected <?php /*endif;*/?> >E</option>
                        <option value="F" <?php /*if($capa->cap_c_geozone_letter == 'F'):*/?> selected <?php /*endif;*/?> >F</option>
                        <option value="G" <?php /*if($capa->cap_c_geozone_letter == 'G'):*/?> selected <?php /*endif;*/?> >G</option>
                        <option value="H" <?php /*if($capa->cap_c_geozone_letter == 'H'):*/?> selected <?php /*endif;*/?> >H</option>
                        <option value="J" <?php /*if($capa->cap_c_geozone_letter == 'J'):*/?> selected <?php /*endif;*/?> >J</option>
                        <option value="K" <?php /*if($capa->cap_c_geozone_letter == 'K'):*/?> selected <?php /*endif;*/?> >K</option>
                        <option value="L" <?php /*if($capa->cap_c_geozone_letter == 'L'):*/?> selected <?php /*endif;*/?> >L</option>
                        <option value="M" <?php /*if($capa->cap_c_geozone_letter == 'M'):*/?> selected <?php /*endif;*/?> >M</option>
                        <option value="N" <?php /*if($capa->cap_c_geozone_letter == 'N'):*/?> selected <?php /*endif;*/?> >N</option>
                        <option value="P" <?php /*if($capa->cap_c_geozone_letter == 'P'):*/?> selected <?php /*endif;*/?> >P</option>
                        <option value="Q" <?php /*if($capa->cap_c_geozone_letter == 'Q'):*/?> selected <?php /*endif;*/?> >Q</option>
                        <option value="R" <?php /*if($capa->cap_c_geozone_letter == 'R'):*/?> selected <?php /*endif;*/?> >R</option>
                        <option value="S" <?php /*if($capa->cap_c_geozone_letter == 'S'):*/?> selected <?php /*endif;*/?> >S</option>
                        <option value="T" <?php /*if($capa->cap_c_geozone_letter == 'T'):*/?> selected <?php /*endif;*/?> >T</option>
                        <option value="U" <?php /*if($capa->cap_c_geozone_letter == 'U'):*/?> selected <?php /*endif;*/?> >U</option>
                        <option value="V" <?php /*if($capa->cap_c_geozone_letter == 'V'):*/?> selected <?php /*endif;*/?> >V</option>
                        <option value="W" <?php /*if($capa->cap_c_geozone_letter == 'W'):*/?> selected <?php /*endif;*/?> >W</option>
                        <option value="X" <?php /*if($capa->cap_c_geozone_letter == 'X'):*/?> selected <?php /*endif;*/?> >X</option>
                        <option value="Z" <?php /*if($capa->cap_c_geozone_letter == 'Z'):*/?> selected <?php /*endif;*/?> >Z</option>
                    </select>
                </div>
            </div>
            </div>-->

            <div class="form-group">
                <label class="col-md-3 col-xs-12 control-label">Capa (*)</label>
                <div class="col-xs-12 col-md-9">
                    <div class="col-xs-12">
                        <div class="radio col-xs-6">
                            <label><input type="radio" name="tipo_capa" value="1" onclick="Layer.mostrarContenedorCapa(this.value);" /> GeoJSON</label>
                        </div>
                        <div class="radio col-xs-6">
                            <label><input type="radio" name="tipo_capa" value="2" onclick="Layer.mostrarContenedorCapa(this.value);" /> Shape</label>
                        </div>
                    </div>
                    <div class="row" style="display:none" id="contenedor_tipo_geojson">
                        <div class="col-md-12 top-spaced">
                            <input id="input-capa-geojson" name="input-capa-geojson" class="form-control"  type="file" data-show-preview="false" />
                        </div>
                    </div>
                    <div class="row" style="display:none" id="contenedor_tipo_shape">
                        <div class="col-md-12 top-spaced">
                            <input id="input-capa-shape" name="input-capa-shape[]" class="form-control"  type="file" data-show-preview="false" multiple />
                        </div>

                    </div>

                    <div class="row" style="display:none" id="cargando_geojson">
                        <div class="col-xs-12">
                            <div class="top-spaced alert alert-info text-left small">
                                <strong>Procesando archivo... <i class="fa fa-spin fa-spinner"></i></strong>
                                <br/>Esto puede demorar dependiendo del tamaño de la capa cargada
                            </div>
                        </div>
                    </div>
                </div>
                <!--                        <div class="col-md-4">-->
                <!--                            <input id="input-capa" name="input-capa[]" class="form-control"  type="file" data-show-preview="false" />-->
                <!--                        </div>-->

            </div>

            <input name="tmp_file" id="tmp_file" type="hidden"/>
            
            <div class="form-group" id="div_properties_editar">
                <label class="col-md-3 control-label">Propiedades de la capa</label>
                <div class="col-md-9">
                    <table id="tabla_propiedades" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>
                                Propiedad
                            </th>
                            <th>
                                Activar
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $propiedadesCapa = explode(',',$capa->cap_c_propiedades);?>
                        <?php foreach($geojson as $propiedad):?>
                            <tr>
                                <td><?php echo $propiedad?></td>
                                <td>
                                    <div class="">
                                        <label>
                                            <input class="propiedades" type="checkbox" name="prop_<?php echo $propiedad?>" id="prop_<?php echo $propiedad?>" value="<?php echo $propiedad?>" <?php if(in_array($propiedad,$propiedadesCapa)):?> checked <?php endif;?> />
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-default btn-square" onclick="xModal.close();">Cancelar</button>
                <button type="button" class="btn btn-success btn-square" onclick="Layer.guardar(this.form,this);">Guardar</button>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        Layer.initSaveEdicion();
    });
    $('#input-capa-geojson').on('fileloaded', function(event, file){
        $("#cargando_geojson").fadeIn();
        $(this).fileinput("upload");
    });

    $('#input-capa-shape').on('fileuploaderror', function(event, data, previewId, index) {
        console.log('File upload error');
        $('#input-capa-shape').fileinput('clear');
    });

    $('#input-capa-shape').on('filebatchselected', function(event, files) {
        if(files.length == 2){
            $("#cargando_geojson").fadeIn();
            $(this).fileinput('upload');
        }

    });
</script>