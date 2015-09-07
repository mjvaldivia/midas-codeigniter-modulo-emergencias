<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Emergencias</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>

    <?php //jquery ?>
    <?= loadJS("assets/lib/jquery-2.1.4/jquery.js") ?>
    <?= loadJS("assets/js/jquery.jcombo.js") ?>

    <?php // bootstrap ?>
    <?= loadCSS("assets/lib/bootstrap-3.3.5/css/bootstrap.css") ?>
    <?= loadJS("assets/lib/bootstrap-3.3.5/js/bootstrap.js") ?>

    <?php //font-awesome ?>
    <?= loadCSS("assets/lib/font-awesome-4.4.0/css/font-awesome.css") ?>

    <?= loadCSS("assets/css/emergencias.min.css") ?>

    <?php //google maps API ?>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing"></script>

    <style type="text/css">
        li a.seccion {
            font-weight: bold;
        }
    </style>

    <script type="text/javascript">
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
    </script>
</head>
<body>
    <div class="header col-md-12">
        <div class="col-md-6">
            <div class="col-md-2 col-xs-2">
                <img src="<?= base_url("/assets/img/logo_visor.jpg") ?>" class="logo-visor">
            </div>
            <div class="col-md-10 col-xs-10">
                <div class="row">
                    <label>Código Emergencia:</label>&nbsp;<span>1</span>
                </div>
                <div class="row">
                    <label>Nombre Emergencia:</label>&nbsp;<span>Demo</span>
                </div>
                <div class="row">
                    <label>Tipo Emergencia:</label>&nbsp;<span>Demo loco</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12" style="padding-right: 0">
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
                <a title="Editar mapa" href="#" onclick="javascript:void(0)" class="btn btn-primary dropdown-toggle" type="button" id="ctrlUpload" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="ctrlDraw">
                    <li>
                        <a class="seccion" href="#" onclick="javascript:void(0)">Lugar de la emergencia</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a id="ctrlDrawLine" href="#">
                            <i class="fa fa-caret-right"></i>
                            Línea
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
                allowedFileExtensions: ["kml"]
            });
        });
    </script>
</body>
</html>