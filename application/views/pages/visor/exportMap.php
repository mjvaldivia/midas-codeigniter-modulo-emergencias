<html>
    <head>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing,geometry"></script>
        <?= loadJS("assets/lib/jquery-2.1.4/jquery.min.js", true) ?>
        <?= loadCSS("assets/lib/bootstrap-3.3.5/css/bootstrap.css", true) ?>
        <?= loadJS("assets/lib/bootstrap-3.3.5/js/bootstrap.js", true) ?>
        <?= loadJS("assets/lib/jquery-ui-1.11.4/jquery-ui.js") ?>
        <?= loadJS("assets/lib/html2canvas/build/html2canvas.js") ?>
        <?= loadJS("assets/js/geo-encoder.js") ?>
        <script type="text/javascript">
            siteUrl = '<?= site_url("/") ?>';
            baseUrl = '<?= base_url("/") ?>';
            $(document).ready(function () {
                ExportMap.LoadMap();
            });
        </script>
        <?= loadJS("assets/js/utils.js") ?>
        <?= loadJS("assets/js/exportMap.js") ?>
    </head>
    <body>
        <input id='eme_ia_id' name='eme_ia_id' value='{id}'>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div id="dvMap" style="width: 1280px; height: 720px;">
                    </div>
                </td>
                <td>
                    &nbsp;
                    &nbsp;
                </td>
                <td>
                    <img id="imgMap" alt="" style="display: none" />
                </td>
            </tr>
        </table>

        <button type="button" onclick="ExportMap.renderImage();">exportar</button> 
    </body>
</html>
