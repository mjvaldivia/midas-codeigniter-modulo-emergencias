<style type="text/css">
    @media (max-width: 480px) {
        #input-buscador-mapa {
            width: 155px
        }
    }
</style>

<input type="hidden" id="hIdEmergencia" name="hIdEmergencia" value="<?= $emergencia["eme_ia_id"] ?>"/>

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
                                <input id="iRadioEmergencia" name="iRadioEmergencia" class="form-control" value="0"/>
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
                                    <a class="btn bg-color1" data-color="black">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color2" data-color="pink">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color3" data-color="green">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color4" data-color="yellow">
                                        <i></i>
                                    </a>
                                    <a class="btn bg-color5" data-color="blue">
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
                            <td></td>
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
                                <th>Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <th>Nombre</th>
                                <th>Categoría</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <input id='selected_items' value=''>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button id="btnCargarCapas" type="button" class="btn btn-primary">Cargar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mInfo">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Cruce de datos</h4>
			</div>
			<div id="mInfoContent" class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div id="moldeCruce" style="display: none">
    <div class="panel panel-default">
        <div class="panel-heading">__titulo__</div>
        <div class="table-responsive">
            <table id="__id_tabla__" class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div id="moldeIns" style="display: none">
    <h4>
        __nombre_fantasia__<br/>
        __razon_social__
    </h4>
    <div class="well">
        __direccion__<br/>
        __comuna__<br/>
        __region__<br/>
        Chile<br/>
        <a href="#" onclick="javascript:void(0)">Ver más</a>
    </div>
</div>

<div id="moldeIns" style="display: none">
    <h4>
        __nombre_fantasia__<br/>
        __razon_social__
    </h4>
    <div class="well">
        __direccion__<br/>
        __comuna__<br/>
        __region__<br/>
        Chile<br/>
        <a href="#" onclick="javascript:void(0)">Ver más</a>
    </div>
</div>

<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css", true) ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js", true) ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js", true) ?>
<?= loadJS("assets/lib/DataTables-1.10.8/extensions/Insensitive/dataTables.insensitive.js") ?>

<?= loadJS("assets/js/geo-encoder.js") ?>
<?= loadJS("assets/js/visor.js") ?>

<script type="text/javascript">
    $(document).ready(function() {
        VisorMapa.init();
    });
</script>