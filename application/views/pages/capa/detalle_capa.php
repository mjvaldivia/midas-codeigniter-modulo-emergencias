<style>
    .fileinput-upload , .fileinput-remove-button, .fileinput-remove,  .kv-file-upload{
        display: none;
    }
</style>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Capas
                <small><i class="fa fa-arrow-right"></i> Administrador de capas</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i><a href="<?= site_url() ?>"> Inicio</a></li>
                <li><i class="fa fa-bell"></i> Administrador de capas </li>
                <?php if (!$editar): ?>
                    <li class="active"><i class="fa fa-bell"></i> Ingreso Capa</li>
                <?php else: ?>
                    <li class="active"><i class="fa fa-bell"></i> Editar Capa</li>
                <?php endif; ?>
            </ol>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- end PAGE TITLE AREA -->


<ul id="ul-tabs" class="nav nav-tabs">
    
    <?php if(puedeEditar("capas")) { ?>
    <li class='<?= tabActive("nuevo", $tab_activo, "header") ?>'>
        <a href="#tab1" data-toggle="tab">Nueva</a>
    </li>
    <?php } ?>
    
    <li class="<?= tabActive("listado", $tab_activo, "header") ?>">
        <a href="#tab2" data-toggle="tab">Listado</a>
    </li>
    <li style="display:none" id="tab-editar"><a href="#tab3" data-toggle="tab">Edición</a></li>
</ul>



<div id="tab-content" class="tab-content">
    <?php if(puedeEditar("capas")) { ?>
    <div class='tab-pane <?= tabActive("nuevo", $tab_activo, "content") ?> top-spaced' id='tab1' style='overflow:hidden;'>
        <div id='div_tab_1' class='col-xs-12'>
            
            <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title"><h4>Datos de la capa</h4></div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" id="form_capas">
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nombre (*)</label>
                        <div class="col-md-7">
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
                        <label class="col-md-3 control-label">Zona Geográfica (*)</label>
                        <div class="col-md-7 row">
                            <div class="col-md-2" style="min-width:10%">
                            
                           <select id="gznumber" name="gznumber" class="form-control">
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option selected value="19">19</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                          <div class="col-md-1" style="min-width:15%">  
                            <select id="gzletter" name="gzletter" class="form-control">
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option  selected value="H">H</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="L">L</option>
                                <option value="M">M</option>
                                <option value="N">N</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option>
                                <option value="T">T</option>
                                <option value="U">U</option>
                                <option value="V">V</option>
                                <option value="W">W</option>
                                <option value="X">X</option>
                                <option value="Z">Z</option>
                            </select>
                        </div>
                    </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Capa(s) (*)</label>
                        <div class="col-md-4">
                            <input id="input-capa" name="input-capa[]" class="form-control" multiple="" type="file" data-show-preview="false" />
                        </div>
                        
                    </div>
                    
                    <div id="div_color" class="hidden">
                        <label class="col-md-3 control-label">Configuración de capa</label>
                        <div class="col-md-9">
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
                    
                    <div class="form-group" id="div_comunas" style="display:none;">
                        <label class="col-md-3 control-label">Comuna de la(s) capa(s)</label>
                        <div class="col-md-9">
                            <table id="tabla_comunas" class="table table-bordered table-striped required" placeholder="Archivo de capa válido">
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
                    <div class="form-group" id="div_properties" style="display:none;">
                        <label class="col-md-3 control-label">Propiedades de la(s) capa(s)</label>
                        <div class="col-md-5">
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
                            </table>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <button type="button" class="pull-right btn btn-default btn-square" onclick="Layer.guardar(this.form,this)">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
</div>

    </div>
    <?php } ?>
    <div class='tab-pane <?= tabActive("listado", $tab_activo, "content") ?>' id='tab2' style='overflow:hidden;'>
        <div id='div_tab_2' class='col-xs-12 top-spaced'>

        </div>

    </div>

    <div class='tab-pane' id='tab3' style='overflow:hidden;display:none'>
        <div id='div_tab_3' class='col-xs-12 top-spaced'>

        </div>

    </div>
</div> 

<?= loadCSS("assets/lib/bootstrap-fileinput/css/fileinput.css") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput.js") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>
<?= loadJS("assets/js/bootbox.min.js") ?>



<?= loadJS("assets/js/capas.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Layer.initSave();
        $('#div_tab_2').load(siteUrl+'capas/listado');
    });
    $('#input-capa').on('fileloaded', function(event, file){
       $(this).fileinput("upload");
    });
</script>