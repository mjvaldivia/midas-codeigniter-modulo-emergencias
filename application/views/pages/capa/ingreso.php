<?php
/**
 * User: claudio
 * Date: 15-09-15
 * Time: 03:24 PM
 */
?>

<ol class="breadcrumb">
    <li><a href="<?= site_url() ?>">Inicio</a></li>
    <?php if (!$editar): ?>
        <li class="active">Ingreso Capa</li>
    <?php else: ?>
        <li class="active">Editar Capa</li>
    <?php endif; ?>
</ol>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Datos de la capa</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Icono</label>
                <div class="col-md-7">
                    <input id="input-icon" name="input-icon" type="file"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Nombre</label>
                <div class="col-md-7">
                    <input type="text" class="form-control"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Comuna</label>
                <div class="col-md-7">
                    <select name="iComunas" id="iComunas" class="form-control"></select>
                </div>
            </div>

            <div class="col-md-12">
                <button type="button" class="col-md-offset-9 btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<?= loadCSS("assets/lib/bootstrap-fileinput/css/fileinput.css") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput.js") ?>
<?= loadJS("assets/lib/bootstrap-fileinput/js/fileinput_locale_es.js") ?>

<?= loadJS("assets/js/capas.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        Layer.initSave();
    });
</script>