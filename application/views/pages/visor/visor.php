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
                <button id="btnCancelarOtrosEmergencia" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="btnGuardarOtrosEmergencia" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mMaestroInstalaciones">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cargar instalaciones</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tblTiposIns" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Ámbito</th>
                                <th>Tipo de instalación</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Ámbito</th>
                                <th>Tipo de instalación</th>
                            </tr>
                        </tfoot>
                    </table>                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="btnCargarIns" type="button" class="btn btn-primary">Cargar</button>
            </div>
        </div>
    </div>
</div>

<a class="btn btn-primary" data-toggle="modal" href='#mCapas'>Trigger modal</a>
<div class="modal fade" id="mCapas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cargar capas</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tblCtrlCapas" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CapaBomberos</td>
                                <td>
                                    Bomberos
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaCarabineros</td>
                                <td>
                                    Carabineros
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaPDI</td>
                                <td>
                                    PDI
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaAreasProtegidas</td>
                                <td>
                                    Áreas Protegidas
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaCuerposAgua</td>
                                <td>
                                    Cuerpos de agua
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaMunicipalidades</td>
                                <td>
                                    Municipalidades
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaComunas</td>
                                <td>
                                    Comunas
                                </td>
                            </tr>
                                
                            <tr>
                                <td>CapaProvincias</td>
                                <td>
                                    Provincias
                                </td>
                            </tr>
                                
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="btnCargarCapas" type="button" class="btn btn-primary">Cargar</button>
            </div>
        </div>
    </div>
</div>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadJS("assets/js/visor.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        VisorMapa.init();
    });
</script>