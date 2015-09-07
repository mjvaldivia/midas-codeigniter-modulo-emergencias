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

<a class="btn btn-primary" data-toggle="modal" href='#mRadioEmergencia'>Trigger modal</a>
<div class="modal fade" id="mRadioEmergencia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Radio de emergencia</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" onsubmit="return false;">
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

<?= loadJS("assets/js/visor.js") ?>
<script type="text/javascript">
    $(document).ready(function() {
        VisorMapa.init();
    });
</script>