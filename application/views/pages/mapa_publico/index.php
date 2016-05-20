<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MIDAS :: Módulo de emergencias</title>
    
    
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("/assets/img/favicon.ico") ?>"/>
    
    
    <?= loadCSS("assets/js/library/selectize-0.12.1/css/selectize.bootstrap3.css") ?>
    <!-- GLOBAL STYLES - Include these on every page. -->
    <?= loadCSS("assets/js/library/bootstrap-3.3.5/css/bootstrap.css", true) ?>
    <?= loadCSS("assets/css/bootstrap.vertical-tabs.css", true) ?>
    <?= loadCSS("assets/js/library/qtip/jquery.qtip.min.css", true) ?>
    <?= loadCSS("assets/js/library/messenger/messenger.css", true) ?>
    <?= loadCSS("assets/js/library/messenger/messenger-theme-flat.css", true) ?>
    <?= loadCSS("assets/js/library/font-awesome-4.4.0/css/font-awesome.css", true) ?>
    <?= loadCSS("assets/js/library/spectrum-colorpicker/spectrum.css") ?>
    

    
</head>
<body>
    

    <div class="row-mapa">

            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

            <!-- Menu slideup para mostrar elementos cargados en el mapa -->
            <div class="row hidden">
                <div class="col-lg-12">
                    <div id="slideup-menu" class="top-menu">
                        <div class="top-menu-main">
                            <ul id="lista_capas_agregadas" class="demo-menu">

                            </ul>
                            <a href="javascript:void(0)" class="menu-item-text">Capas <span id="cantidad_capas_agregadas" class="badge">0</span></a> 
                        </div>
                        <div class="top-menu-main">
                            <ul id="lista_elementos_agregados" class="demo-menu">

                            </ul>
                            <a href="javascript:void(0)" class="menu-item-text">Elementos <span id="cantidad_elementos_agregados" class="badge">0</span></a> 
                        </div>
                        <div class="top-menu-main">
                            <ul id="lista_importados_agregados" class="demo-menu">

                            </ul>
                            <a href="javascript:void(0)" class="menu-item-text">Importados <span id="cantidad_elementos_importados" class="badge">0</span></a> 
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
    
</body>
<footer>
    <script type="text/javascript">
        siteUrl = '<?= site_url("/") ?>';
        baseUrl = '<?= base_url("/") ?>';
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBqmaRNgLR0AZU8l7PPITUFJ4EBQD_A_4g"></script>
    <script type='text/javascript' src="<?= base_url("/assets/js/library/jquery-2.1.4/jquery.min.js") ?>"></script>
    <?= loadJS("assets/js/library/joii-3.1.3/joii.min.js", true) ?>
    <?= loadJS("assets/js/library/bootstrap-3.3.5/js/bootstrap.js", true) ?>
    <?= loadJS("assets/js/library/popupoverlay/jquery.popupoverlay.js", true) ?>
    <?= loadJS("assets/js/library/livequery/jquery.livequery.min.js", true) ?>
    <?= loadJS("assets/js/library/popupoverlay/defaults.js", true) ?>
    <?= loadJS("assets/js/library/popupoverlay/logout.js", true) ?>
    <?= loadJS("assets/js/library/jquery.jcombo/jquery.jcombo.js", true) ?>
    <?= loadJS("assets/js/library/qtip/jquery.qtip.min.js", true) ?>

    <?= loadCSS("assets/js/library/chosen_v1.5.1/chosen.min.css") ?>

    <?= loadJS("assets/js/library/chosen_v1.5.1/chosen.jquery.min.js") ?>
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
    <?= loadJS("assets/js/library/selectize-0.12.1/js/standalone/selectize.js") ?>
    <?= loadJS("assets/js/library/jquery.wait.js") ?>
    <?= loadJS("assets/js/base.js") ?>
    <?php echo layoutJs(); ?>
    <?php echo $js; ?>
    <?= loadCSS("assets/css/modulo/mapa_publico.css", true) ?>
    <?= loadJS("assets/js/mapa-publico.js"); ?>
</footer>
</html>