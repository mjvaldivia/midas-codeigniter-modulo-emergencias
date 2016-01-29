<div class="portlet portlet-green">
    <div class="portlet-heading">
        <div class="portlet-title"><h4>Datos de la capa</h4></div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" id="form_capas">

            <div class="form-group">
                <label class="col-xs-12 col-md-3 control-label">Nombre (*)</label>
                <div class="col-xs-12 col-md-9">
                    <input type="text" id="nombre" name="nombre" class="form-control required" placeholder="Nombre de la(s) Capa(s)" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Categoría (*)</label>
                <div class="col-md-7">
                    <select id="iCategoria" name="iCategoria" class="form-control required" placeholder="Categoría de la(s) Capa(s)"></select>
                </div>
            </div>
            <!--                    <div class="form-group">-->
            <!--                        <label class="col-md-3 control-label">Zona Geográfica (*)</label>-->
            <!--                        <div class="col-md-7 row">-->
            <!--                            <div class="col-md-2" style="min-width:10%">-->
            <!--                            -->
            <!--                           <select id="gznumber" name="gznumber" class="form-control">-->
            <!--                                <option value="12">12</option>-->
            <!--                                <option value="13">13</option>-->
            <!--                                <option value="14">14</option>-->
            <!--                                <option value="15">15</option>-->
            <!--                                <option value="16">16</option>-->
            <!--                                <option value="17">17</option>-->
            <!--                                <option value="18">18</option>-->
            <!--                                <option selected value="19">19</option>-->
            <!--                                <option value="20">20</option>-->
            <!--                            </select>-->
            <!--                        </div>-->
            <!--                          <div class="col-md-1" style="min-width:15%">  -->
            <!--                            <select id="gzletter" name="gzletter" class="form-control">-->
            <!--                                <option value="C">C</option>-->
            <!--                                <option value="D">D</option>-->
            <!--                                <option value="E">E</option>-->
            <!--                                <option value="F">F</option>-->
            <!--                                <option value="G">G</option>-->
            <!--                                <option  selected value="H">H</option>-->
            <!--                                <option value="J">J</option>-->
            <!--                                <option value="K">K</option>-->
            <!--                                <option value="L">L</option>-->
            <!--                                <option value="M">M</option>-->
            <!--                                <option value="N">N</option>-->
            <!--                                <option value="P">P</option>-->
            <!--                                <option value="Q">Q</option>-->
            <!--                                <option value="R">R</option>-->
            <!--                                <option value="S">S</option>-->
            <!--                                <option value="T">T</option>-->
            <!--                                <option value="U">U</option>-->
            <!--                                <option value="V">V</option>-->
            <!--                                <option value="W">W</option>-->
            <!--                                <option value="X">X</option>-->
            <!--                                <option value="Z">Z</option>-->
            <!--                            </select>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->


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

            <div id="div_color" class="hidden">
                <label class="col-md-3 col-xs-12 control-label">Configuración de capa</label>

                    <div class="col-md-9 col-xs-12">
                        <div class="row">
                        <table id="tabla_colores" class="table table-bordered table-striped required" placeholder="Archivo de capa válido">
                            <thead>
                            <tr>
                                <th>
                                    Tipo
                                </th>
                                <th>
                                    Color/icono
                                </th>
                            </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
            </div>
            <input name="tmp_file" id="tmp_file" type="hidden"/>

            <div class="" id="div_properties" style="display:none;">
                <label class="col-md-3 col-xs-12 control-label">Atributos de la capa</label>
                <div class="col-md-9 col-xs-12">
                    <div class="row">
                        <table id="tabla_propiedades" class="table table-bordered table-striped">
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
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right top-spaced">
                <button type="button" class="btn btn-default btn-square" onclick="xModal.close();">Cerrar</button>
                <button type="button" class="btn btn-success btn-square" id="btn-guardar-capa" disabled onclick="Layer.guardar(this.form,this)">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        Layer.initSave();
        //$('#div_tab_2').load(siteUrl+'capas/listado');
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