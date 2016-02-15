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
                            <input id="input-capa-shape" name="input-capa-shape[]" class="form-control"  type="file" data-show-preview="false" multiple/>
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
    });
    
    $('#input-capa-geojson').on('fileloaded', function(event, file){
        $("#cargando_geojson").fadeIn();
        $(this).fileinput("upload");
    });

    $('#input-capa-shape').on('fileuploaderror', function(event, data, previewId, index) {
        $('#input-capa-shape').fileinput('clear');
    });

    $('#input-capa-shape').on('filebatchselected', function(event, files) {
        if(files.length == 2){
            $("#cargando_geojson").fadeIn();
            $(this).fileinput('upload');
        }

    });
</script>