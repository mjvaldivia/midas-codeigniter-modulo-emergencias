
<div class="portlet portlet-default">
    <div class="portlet-heading">
        <div class="portlet-title"><h4>Editando capa</h4></div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" id="form_capas_edicion">
            <input type="hidden" name="capa_edicion" id="capa_edicion" value="<?php echo $capa->cap_ia_id?>" />
            <div class="form-group">
                <label class="col-md-3 control-label">Nombre (*)</label>
                <div class="col-md-7">
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
            <div class="form-group">
                <label class="col-md-3 control-label">Comuna (*)</label>
                <div class="col-md-7">
                    <select id="comuna_editar" name="comuna_editar" class="form-control required" placeholder="Comuna Capa">
                        <?php foreach($comunas as $comuna):?>
                        <option value="<?php echo $comuna->com_ia_id?>" <?php if($capa->com_ia_id == $comuna->com_ia_id):?> selected <?php endif;?> ><?php echo $comuna->com_c_nombre?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Zona Geográfica (*)</label>
                <div class="col-md-7 row">
                    <div class="col-md-2" style="min-width:10%">
                    
                   <select id="gznumber_editar" name="gznumber_editar" class="form-control">
                        <option value="12" <?php if($capa->cap_c_geozone_number == 12):?> selected <?php endif;?> >12</option>
                        <option value="13" <?php if($capa->cap_c_geozone_number == 13):?> selected <?php endif;?> >13</option>
                        <option value="14" <?php if($capa->cap_c_geozone_number == 14):?> selected <?php endif;?> >14</option>
                        <option value="15" <?php if($capa->cap_c_geozone_number == 15):?> selected <?php endif;?> >15</option>
                        <option value="16" <?php if($capa->cap_c_geozone_number == 16):?> selected <?php endif;?> >16</option>
                        <option value="17" <?php if($capa->cap_c_geozone_number == 17):?> selected <?php endif;?> >17</option>
                        <option value="18" <?php if($capa->cap_c_geozone_number == 18):?> selected <?php endif;?> >18</option>
                        <option value="19" <?php if($capa->cap_c_geozone_number == 19):?> selected <?php endif;?> >19</option>
                        <option value="20" <?php if($capa->cap_c_geozone_number == 20):?> selected <?php endif;?> >20</option>
                    </select>
                </div>
                  <div class="col-md-1" style="min-width:15%">  
                    <select id="gzletter" name="gzletter" class="form-control">
                        <option value="C" <?php if($capa->cap_c_geozone_letter == 'C'):?> selected <?php endif;?> >C</option>
                        <option value="D" <?php if($capa->cap_c_geozone_letter == 'D'):?> selected <?php endif;?> >D</option>
                        <option value="E" <?php if($capa->cap_c_geozone_letter == 'E'):?> selected <?php endif;?> >E</option>
                        <option value="F" <?php if($capa->cap_c_geozone_letter == 'F'):?> selected <?php endif;?> >F</option>
                        <option value="G" <?php if($capa->cap_c_geozone_letter == 'G'):?> selected <?php endif;?> >G</option>
                        <option value="H" <?php if($capa->cap_c_geozone_letter == 'H'):?> selected <?php endif;?> >H</option>
                        <option value="J" <?php if($capa->cap_c_geozone_letter == 'J'):?> selected <?php endif;?> >J</option>
                        <option value="K" <?php if($capa->cap_c_geozone_letter == 'K'):?> selected <?php endif;?> >K</option>
                        <option value="L" <?php if($capa->cap_c_geozone_letter == 'L'):?> selected <?php endif;?> >L</option>
                        <option value="M" <?php if($capa->cap_c_geozone_letter == 'M'):?> selected <?php endif;?> >M</option>
                        <option value="N" <?php if($capa->cap_c_geozone_letter == 'N'):?> selected <?php endif;?> >N</option>
                        <option value="P" <?php if($capa->cap_c_geozone_letter == 'P'):?> selected <?php endif;?> >P</option>
                        <option value="Q" <?php if($capa->cap_c_geozone_letter == 'Q'):?> selected <?php endif;?> >Q</option>
                        <option value="R" <?php if($capa->cap_c_geozone_letter == 'R'):?> selected <?php endif;?> >R</option>
                        <option value="S" <?php if($capa->cap_c_geozone_letter == 'S'):?> selected <?php endif;?> >S</option>
                        <option value="T" <?php if($capa->cap_c_geozone_letter == 'T'):?> selected <?php endif;?> >T</option>
                        <option value="U" <?php if($capa->cap_c_geozone_letter == 'U'):?> selected <?php endif;?> >U</option>
                        <option value="V" <?php if($capa->cap_c_geozone_letter == 'V'):?> selected <?php endif;?> >V</option>
                        <option value="W" <?php if($capa->cap_c_geozone_letter == 'W'):?> selected <?php endif;?> >W</option>
                        <option value="X" <?php if($capa->cap_c_geozone_letter == 'X'):?> selected <?php endif;?> >X</option>
                        <option value="Z" <?php if($capa->cap_c_geozone_letter == 'Z'):?> selected <?php endif;?> >Z</option>
                    </select>
                </div>
            </div>
            </div>
            <div class="form-group">
                <?php $icon = explode("/",$capa->icono);?>
                <?php $icono = array_pop($icon);?>
                <label class="col-md-3 control-label">Icono (*)</label>
                <div class="col-md-4">
                    <input id="input-icon-editar" name="input-icon-editar" class="form-control" placeholder="Icono de la(s) Capa(s)" type="file" data-show-preview="false" value="<?php echo $icono?>" />
                    <input id="icon-editar" value='<?php echo $icono?>' name="icon-editar" class="form-control required" placeholder="Icono de la(s) Capa(s)" type="hidden" />
                    
                </div>
                <div class="col-md-2"><img id='img_icon_editar' height="32px" src="<?php echo $capa->icono?>"/></div>
            </div>
            
            <div class="form-group">
                <?php $capa_file = explode("/",$capa->capa);?>
                <?php $capa_file = array_pop($capa_file);?>
                <label class="col-md-3 control-label">Capa (*)</label>
                <div class="col-md-4">
                    <input id="input-capa-editar" value="<?php echo $capa_file?>" name="input-capa-editar[]" class="form-control" type="file" data-show-preview="false" />
                </div>
                <div class="col-md-5">
                    <p class="form-control-static" id="nombre_geojson"><?php echo $capa_file?></p>
                </div>
                  
                
            </div>
            
            
            <div class="form-group" id="div_comunas_editar" style="display:none;">
                <label class="col-md-3 control-label">Comuna de la capa</label>
                <div class="col-md-9">
                    <table id="tabla_comunas_editar" class="table table-bordered table-striped required" placeholder="Archivo de capa válido">
                        <thead>
                        <tr>
                            <th>
                                Archivo
                            </th>
                            <th>
                                Comuna
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="form-group" id="div_properties_editar">
                <label class="col-md-3 control-label">Propiedades de la(s) capa(s)</label>
                <div class="col-md-5">
                    <table id="tabla_propiedades-editar" class="table table-bordered table-striped dataTable">
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
                        <?php $propiedades = explode(',',$capa->cap_c_propiedades);?>
                        <?php foreach($propiedades as $propiedad):?>
                            <tr>
                                <td><?php echo $propiedad?></td>
                                <td>
                                    <div class="checkbox">
                                        <label><input class="propiedades" type="checkbox" name="prop_<?php echo $propiedad?>" id="prop_<?php echo $propiedad?>" value="<?php echo $propiedad?>" checked /></label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-10 text-right">
                <button type="button" class="btn btn-green btn-square" onclick="Layer.guardar(this.form,this);">Guardar</button>
                <button type="button" class="btn btn-default btn-square" onclick="Layer.cancelarEdicion();">Cancelar</button>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        Layer.initSaveEdicion();
        
    });
    $('#input-capa-editar').on('fileloaded', function(event, file){
       $(this).fileinput("upload");
    });
    $('#input-icon-editar').on('fileloaded', function(event, file){

       $(this).fileinput("upload");
    });

</script>