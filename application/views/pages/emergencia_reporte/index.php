<?php echo $js; ?>
<div class="col-lg-12">
    <form name="form_reporte_emergencia" id ="form_reporte_emergencia">
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
        <div class="row">
            <div class="col-lg-6">
                <div id="mapa">
                    <div class="col-lg-12 text-center top-spaced-doble">
                        <i class="fa fa-4x fa-spin fa-spinner"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="form-group">
                        <label class="col-xs-12">Seleccione destinatarios (*)</label>
                        <div class="col-xs-12">
                            <textarea id="tokenfield" class="form-control required" placeholder="ingrese destinatario(s)...">vladimir@cosof.cl</textarea>
                        </div>
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="form-group">
                        <label class="col-xs-12">Asunto</label>
                        <div class="col-xs-12">
                            <input id="asunto" class="form-control" type="text" placeholder="ingrese asunto..." value="Emergencia: <?php echo $nombre; ?>" name="asunto">
                        </div>
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="form-group">
                        <label class="col-xs-12">Mensaje</label>
                        <div class="col-xs-12">
                            <textarea id="mensaje" class="form-control" placeholder="ingrese mensaje..." name="mensaje" style="resize: none;" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="top-spaced">
                    <div class="col-xs-6">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked" name="copia" id="copia" value="1"> Enviarme una copia 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked" name="adjuntar_reporte" id="adjuntar_reporte" value="1"> Adjuntar reporte
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="clearfix"></div>
<?= loadJS("assets/lib/html2canvas/build/html2canvas.js"); ?>
<?= loadJS("assets/js/modulo/emergencia_reporte/mapa/imagen.js"); ?>
<?= loadJS("assets/js/modulo/emergencia_reporte/front-end.js"); ?>
