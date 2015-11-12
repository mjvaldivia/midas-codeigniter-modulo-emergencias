
<?= loadJS("assets/js/MapReport.js") ?>
<script type="text/javascript">
    $(document).ready(function () {

        MapReport.LoadMap();
        MapReport.dibujaTablaDocs();
    });

</script>

<style>
    .ui-autocomplete {
        z-index: 5000;
    }
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-file-pdf-o"></i>
            Ajustes del Reporte Emergencia : <?= $nombre_emergencia ?>
        </h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <form id="form_reporte" >

            <input type="hidden" id='eme_ia_id' name="eme_ia_id" value='{id}'>
            <input type="hidden" id='ala_ia_id' name="ala_ia_id" value='{ala_ia_id}'>

            <ul id="ul-tabs" class="nav nav-tabs">
                <li class='active'><a href="#tab1" data-toggle="tab">Envío de reporte por e-mail</a></li>

            </ul>
            <div id="tab-content" class="tab-content">
                <div class='tab-pane active' id='tab1' style='overflow:hidden;'>
                    <br>
                    <div class="col-xs-12">
                        <div class="col-md-6 col-xs-12">
                            <div class="text-center"><b>Puede ajustar la vista del mapa para el reporte</b></div>
                            <div id='dvMap' style="height: 350px;" class="col-md-12"></div>
                            
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="col-xs-12">
                                <div class="form-horizontal">
                                    <div  class='form-group'>
                                        <label class="col-xs-12">Seleccione destinatarios (*)</label>
                                        <div class="col-xs-12">
                                            <textarea  class="form-control required" id="tokenfield" placeholder="ingrese destinatario(s)..."><?= $lista ?></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div >

                            <div class="col-xs-12">
                                <div class="form-horizontal">
                                    <div  class='form-group'>
                                        <label class="col-xs-12">Asunto</label>
                                        <div class="col-xs-12">
                                            <input type="text"  class="form-control" id="asunto" name="asunto" value="Emergencia: {nombre_emergencia}" placeholder="ingrese asunto..." />
                                        </div>

                                    </div>
                                </div>
                            </div >
                            <div class="col-xs-12">
                                <div class="form-horizontal">
                                    <div  class='form-group'>
                                        <label class="col-xs-12">Mensaje</label>
                                        <div class="col-xs-12">
                                            <textarea rows="5" style="resize: none;"  class="form-control" id="mensaje" name="mensaje"  placeholder="ingrese mensaje..." ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div >
                            <div class="col-xs-12">
                                <div class="form-horizontal">
                                    <div  class='form-group'>

                                        <div class="col-md-3 col-xs-12 checkbox">
                                            <label >
                                                <input type="checkbox"  class="" id="con_copia" name="con_copia" checked="true"/>&nbsp;Enviarme una copia
                                            </label>
                                        </div>
                                        <div class="col-md-3 col-xs-12 checkbox">
                                            <label >
                                                <input type="checkbox"  class="" id="adj_reporte" name="adj_reporte" checked="true"/>&nbsp;Adjuntar reporte 
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-xs-12">

                                            <a onclick="MapReport.cloneMap();" class="btn btn-md btn-warning" ><i class="fa fa-file-pdf-o"></i> Ver Reporte</a>
                                            <a onclick="MapReport.send_mail();" class="btn btn-md btn-success" ><i class="fa fa-envelope-o"></i> Enviar Correo</a>

                                        </div>
                                    </div>
                                </div>
                            </div >
                        </div >
                    </div >

                    <br>
                    <hr>
                    <div class="col-sm-12"  style="position: absolute; margin-top: 0px; z-index: -999">
                        <div class="col-sm-6" id='clon' style="height: 350px; z-index: -999">

                        </div>

                    </div>
                    <br>
                    <div class="col-xs-12">
                        
                        <div  class='form-group'>
                            <label class="col-xs-12">Seleccione archivos para adjuntar</label>
                            <div class="col-md-12 table-responsive"> 
                                <table id="tabla_doc" class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <td>Nombre Archivo</td>
                                            <td>Autor</td>
                                            <td>Fecha</td>
                                            <td></td>
                                            <td style="width: 10px !important;">Adjuntar</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div >
                    <div class="col-xs-12"></div>
                    <br>
                </div>

            </div>
            </form>
        </div>


    </div>


</div>






