<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Emergencias</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>

    <?php //jquery ?>
    <?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
    <?= loadJS("assets/js/jquery.jcombo.js", true) ?>

    <?php // bootstrap ?>
    <?= loadCSS("assets/lib/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <?= loadJS("assets/lib/bootstrap-3.3.5/js/bootstrap.js", true) ?>

    <?php //font-awesome ?>
    <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css", true) ?>

    <?= loadCSS("assets/css/emergencias.css") ?>
    <?= loadJS("assets/js/utils.js") ?>
    <?= loadJS("assets/js/loading.js") ?>

    <?php //google maps API ?>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing,geometry"></script>

    <style type="text/css">
        li a.seccion {
            font-weight: bold;
        }

        body {
            position: relative;
            height: 100%;
        }
    </style>

    <script type="text/javascript">
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
    </script>
</head>
<body>
    <div class='cargando'><img src="<?= base_url("assets/img/loading.gif") ?>"/><span>Cargando...</span></div>
    <div class="header col-md-12">
        <div class="col-md-9">
            <div class="col-md-2 col-xs-2">
                <img src="<?= base_url("/assets/img/logo_visor.jpg") ?>" class="logo-visor">
            </div>
            <div class="col-md-10 col-xs-10">
                <div class="row">
                    <div class="col-md-2 col-xs-2"><label>Código Emergencia:</label>&nbsp;<span><?= $emergencia["eme_ia_id"] ?></span></div>
                    <div class="col-md-5 col-xs-5"><label>Nombre Emergencia:</label>&nbsp;<span><?= $emergencia["eme_c_nombre_emergencia"] ?></span></div>
                    <div class="col-md-4 col-xs-4"><label>Tipo Emergencia:</label>&nbsp;<span><?= $emergencia["tipo_emergencia"] ?></span></div>
                </div>
               
            </div>
        </div>
        <div class="col-md-3 col-xs-12" style="padding-right: 0">
            <div class="dropdown pull-right">
                <a title="Subir capa" href="#" onclick="javascript:void(0)" class="btn btn-primary dropdown-toggle" type="button" id="ctrlUpload" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-upload"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="ctrlUpload">
                    <li>
                        <a href="#modal-kml" data-toggle="modal">
                            <i class="fa fa-caret-right"></i>
                            KML
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown pull-right">
                <a title="Editar mapa" href="#" onclick="javascript:void(0)" class="btn btn-primary dropdown-toggle" type="button" id="ctrlDraw" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="ctrlDraw">
                    <li>
                        <a class="seccion" href="#" onclick="javascript:void(0)">Lugar de la emergencia</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a id="ctrlDrawMarker" href="#">
                            <i class="fa fa-caret-right"></i>
                            Marcador
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="seccion" href="#" onclick="javascript:void(0)">Otros datos</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a id="ctrlOtherDrawLine" href="#">
                            <i class="fa fa-caret-right"></i>
                            Línea
                        </a>
                    </li>
                    <li>
                        <a id="ctrlOtherDrawRectangle" href="#">
                            <i class="fa fa-caret-right"></i>
                            Rectángulo
                        </a>
                    </li>
                    <li>
                        <a id="ctrlOtherDrawCircle" href="#">
                            <i class="fa fa-caret-right"></i>
                            Círculo
                        </a>
                    </li>
                    <li>
                        <a id="ctrlOtherDrawPolygon" href="#">
                            <i class="fa fa-caret-right"></i>
                            Polígono
                        </a>
                    </li>
                    <li>
                        <a id="ctrlOtherDrawMarker" href="#">
                            <i class="fa fa-caret-right"></i>
                            Marcador
                        </a>
                    </li>
                    <li class="divider ctrlPowerOff" style="display: none"></li>
                    <li class="ctrlPowerOff" style="display: none">
                        <a id="ctrlDrawOFF" href="#">
                            <i class="fa fa-power-off"></i>
                            Apagar
                        </a>
                    </li>
                </ul>
            </div>

            <a id="ctrlIns" title="Maestro de instalaciones" class="btn btn-primary pull-right">
                <i class="fa fa-building"></i>
            </a>

            <a id="ctrlInfo" href="#" title="Muestra información" class="btn btn-primary pull-right">
                <i class="fa fa-info-circle"></i>
            </a>

            <a id="ctrlLayers" href="#" title="Capas" class="btn btn-primary pull-right">
                <i class="fa fa-clone"></i>
            </a>
            <a id="ctrlSave" href="#" title="Guardar" class="btn btn-primary pull-right">
                <i class="fa fa-floppy-o"></i>
            </a>
        </div>
    </div>
    <div class="main col-md-12 col-xs-12">
        {body}
    </div>

    <div class="modal fade" id="modal-kml">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Importar KML</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-md-2">KML a cargar:</label>
                            <div class="col-md-10">
                                <input id="input-kml" name="input-kml[]" type="file" data-show-preview="false"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?= loadCSS("assets/lib/bootstrap-fileinput/css/fileinput.css") ?>
    <?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput.js") ?>
    <?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput_locale_es.js") ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#input-kml").fileinput({
                language: "es",
                uploadUrl: siteUrl + "visor/subirKML",
                uploadAsync: true,
                initialCaption: "Seleccione KML",
                allowedFileExtensions: ["kml","kmz"]
            });
            Utils.ajaxRequestMonitor();
        });
    </script>
</body>
</html>