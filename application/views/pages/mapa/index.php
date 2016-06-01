
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>MIDAS :: Módulo de emergencias</title>    

    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBqmaRNgLR0AZU8l7PPITUFJ4EBQD_A_4g"></script>
    <script type='text/javascript' src="<?= base_url("/assets/js/library/jquery-2.1.4/jquery.min.js") ?>"></script>
    
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>
    
    <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
    <?= loadCSS("assets/js/library/pace/pace.css", true) ?>
    <?= loadJS("assets/js/library/pace/pace.js", true) ?>    
    
    <?= loadCSS("assets/js/library/messenger/messenger.css", true) ?>
    <?= loadCSS("assets/js/library/messenger/messenger-theme-flat.css", true) ?>
    
    <?= loadJS("assets/js/library/joii-3.1.3/joii.min.js", true) ?>
    <?= loadCSS("assets/js/library/selectize-0.12.1/css/selectize.bootstrap3.css") ?>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <?= loadCSS("assets/js/library/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <?= loadCSS("assets/css/bootstrap.vertical-tabs.css", true) ?>
    <?= loadCSS("assets/js/library/qtip/jquery.qtip.min.css", true) ?>

    <?= loadCSS("assets/js/library/font-awesome-4.4.0/css/font-awesome.css", true) ?>
    <?= loadCSS("assets/js/library/spectrum-colorpicker/spectrum.css") ?>
    
    
    
    <!-- THEME STYLES - Include these on every page. -->
    <?= loadCSS("assets/css/style.css", true) ?>
    <?= loadJS("assets/js/Modal_Sipresa.js") ?>
    <?= loadJS("assets/js/xmodal.js") ?>
    
    <script type="text/javascript">
        
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
        $(document).ready(function(){
            $('body').on('click', '.modal-sipresa', function (event) {
                event.preventDefault();


                // $($(this).attr('data-target')).removeData('bs.modal').modal({remote: $(this).attr('href') });

                var a = $(this);
                var id = a.attr('data-target').replace('#', '');
                //$('#'+id).remove();
                // $('.dynamic-modal .modal-content').empty();
                var style = (a.attr('data-style') != '') ? a.attr('data-style') : 'width:70%;';

                $("body").append("<div class='modal fade dynamic-modal' data-backdrop='static' data-keyboard='false' id=" + id + " tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>" +
                        "<div class='modal-dialog modal-lg' style='" + style + "'>" +
                        "</div>" +
                        "</div>");
                ModalSipresa.addSuccess(id, a, $(this).attr('data-href'));
            });
            });
    </script>

     <?= loadJS("assets/js/library/bootstrap-3.3.5/js/bootstrap.js", true) ?>
        <?= loadJS("assets/js/library/popupoverlay/jquery.popupoverlay.js", true) ?>
        <?= loadJS("assets/js/library/livequery/jquery.livequery.min.js", true) ?>
        <?= loadJS("assets/js/library/popupoverlay/defaults.js", true) ?>
        <?= loadJS("assets/js/library/popupoverlay/logout.js", true) ?>
        <?= loadJS("assets/js/library/jquery.jcombo/jquery.jcombo.js", true) ?>
        <?= loadJS("assets/js/library/qtip/jquery.qtip.min.js", true) ?>
        

        <?= loadCSS("assets/js/library/select2-4.0.0/css/select2.css", true) ?>
        <?= loadCSS("assets/js/library/select2-4.0.0/css/select2-bootstrap.css", true) ?>
        <?= loadJS("assets/js/library/select2-4.0.0/js/select2.js", true) ?>
        
        <?= loadJS("assets/js/library/jquery.mask-1.10.8/jquery.mask.js") ?>
        
        <?= loadJS("assets/js/library/moment-2.11.2/moment.min.js") ?>
        <?= loadJS("assets/js/library/moment-2.11.2/es.js") ?>
        <?= loadCSS("assets/js/library/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css") ?>
        <?= loadJS("assets/js/library/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>
        
        <?= loadJS("assets/js/library/messenger/messenger.min.js", true) ?>
        <?= loadJS("assets/js/library/messenger/messenger-theme-flat.js", true) ?>
        <?= loadJS("assets/js/library/spectrum-colorpicker/spectrum.js") ?>
        <?= loadJS("assets/js/library/selectize-0.12.1/js/standalone/selectize.min.js") ?>
         <?= loadJS("assets/js/library/jquery.wait.js") ?>
    <?= loadCSS("assets/js/library/chosen_v1.5.1/chosen.min.css") ?>
       
        <?= loadJS("assets/js/library/chosen_v1.5.1/chosen.jquery.min.js") ?>
        <?= loadJS("assets/js/base.js") ?>
        <?= loadJS("assets/js/utils.js") ?>

        

<?= loadCSS("assets/css/modulo/mapa.css"); ?>

<?php echo $js; ?>
    <?= loadJS("assets/js/library/ckeditor-4.5.7/ckeditor.js") ?>
    <?= loadJS("assets/js/library/bootstrap-ckeditor-modal-fix.js") ?>
</head>

<div class="row-mapa" style="height: auto">


        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        
        
        <div class="row">
            <div class="collapse navbar-collapse hidden" id="menu-derecho">
                <ul class="nav navbar-nav navbar-left">
                
                <li>
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o"></i> Archivo <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                       
                            <li>
                                <a id="btn-guardar" href="javascript:void(0)"><i class="fa fa-save"></i> Guardar</a>
                            </li>
                            <li class="divider"></li>

                       
                        <li class="dropdown-submenu">
                            <a href="javascript:void(0)"><i class="fa fa-upload"></i> Exportar</a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a  id="btn-exportar-kml" href="javascript:void(0)"> <i class="fa fa-map"></i> Kmz </a>
                                </li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                        
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="javascript:void(0)"><i class="fa fa-download"></i> Importar</a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a  id="btn-importar-kml" href="javascript:void(0)"> <i class="fa fa-map"></i> Kml/Kmz </a>
                                </li>
                                <!--<li>
                                    <a id="btn-importar-excel" href="#"> <i class="fa fa-table"></i> Excel </a>
                                </li>-->
                                <li class="divider"></li>
                            </ul>
                        </li>
                       
                    </ul>
                </li>
                
                <li class="dropdown dropdown-large">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-object-group"></i> Capas <b class="caret"></b></a>

                    <ul id="capas-menu" class="dropdown-menu dropdown-menu-large row" style="overflow-y: scroll; width:90%">
                        <li class="col-sm-3">
                            <ul id="capas-columna-1" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-2" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-3" class="capas-columna">

                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul id="capas-columna-4" class="capas-columna">

                            </ul>
                        </li>
                    </ul>
                </li>

                </ul>
             </div><!-- /.navbar-collapse -->
        </div>
      

        <!-- Menu slideup para mostrar elementos cargados en el mapa -->
        <div class="row hidden">
            <div class="col-lg-12">
                
                
                
                <div id="slideup-menu" class="top-menu">
                    <div class="btn-group">
                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                           <span id="cantidad_capas_agregadas" class="badge">0</span> Capas <span class="caret caret-up"></span>
                        </button>
                        <ul id="lista_capas_agregadas" class="dropdown-menu drop-up" style="width:480px" role="menu">
                            
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                           <span id="cantidad_elementos_agregados" class="badge">0</span> Elementos <span class="caret caret-up"></span>
                        </button>
                        <ul id="lista_elementos_agregados" class="dropdown-menu drop-up" style="width:480px" role="menu">

                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                           <span id="cantidad_elementos_importados" class="badge">0</span> Importados <span class="caret caret-up"></span>
                        </button>
                        <ul id="lista_importados_agregados" class="dropdown-menu drop-up" style="width:480px" role="menu">

                        </ul>
                    </div>
                </div>
            </div>
        </div>

   
        <div id="mapa" style="height: 2000px">
            <div class="col-lg-12 text-center" style="padding-top: 200px">
                <i class="fa fa-4x fa-spin fa-spinner"></i>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?= loadJS("assets/js/mapa-visor.js") ?>

</html>
