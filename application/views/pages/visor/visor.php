<style type="text/css">
    @media (max-width: 480px) {
        #input-buscador-mapa {
            width: 155px
        }
    }
</style>


<input id="input-buscador-mapa" class="map-controls" type="text" placeholder="Buscador de dirección"/>
<div id="capture"></div>
<div id="mapa" class="col-md-12 visor-emergencias">
</div>
<div class="modal fade" id="mRadioEmergencia" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Radio de emergencia</h4>
            </div>
            <div class="modal-body">
                <form id="frmRadioEmergencia" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-6 control-label">Indique metros:</label>
                            <div class="col-md-2">
                                <input id="iRadioEmergencia" name="iRadioEmergencia" class="form-control" value="0"></input>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnGuardarRadioEmergencia" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<a class="btn btn-primary" data-toggle="modal" href='#mOtrosEmergencias'>Trigger modal</a>
<div class="modal fade" id="mOtrosEmergencias" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Información componente</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-offset-1 col-md-3 control-label">Título</label>
                            <div class="col-md-6">
                                <input id="iTituloComponente" type="text" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-offset-1 col-md-3 control-label">Color</label>
                            <div class="col-md-6">
                                <div id="botoneraColorControl" class="btn-group" role="group">
                                    <a class="btn bg-color1">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color2">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color3">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color4">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color5">
                                        <i></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnGuardarOtrosEmergencia" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?= loadJS("assets/js/visor.js") ?>
<script type="text/javascript">
    $(document).ready(function() {
        VisorMapa.init();
    });
</script>