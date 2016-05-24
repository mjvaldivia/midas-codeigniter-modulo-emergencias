<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">

                <table class="table table-condensed table-hover table-bordered" style="margin-bottom: 0;">
                    <tbody>
                    <tr>
                        <td class="text-right text-bold bg-primary bg-primary" width="25%" >Nombre Evento</td>
                        <td class="text-left active active" width="25%" ><?php echo $emergencia->eme_c_nombre_emergencia?></td>

                        <td class="text-right text-bold bg-primary" width="25%" >Estado Evento</td>
                        <td class="text-left active" width="25%" ><?php echo badgeNombreAlarmaEstado($emergencia->est_ia_id); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Origen de Información</td>
                        <td class="text-left active" ><?php echo $emergencia->eme_c_nombre_informante?></td>

                        <td class="text-right text-bold bg-primary" >Fecha Evento</td>
                        <td class="text-left active" ><?php echo ISODateTospanish($emergencia->eme_d_fecha_emergencia)?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Lugar</td>
                        <td class="text-left active" ><?php echo $emergencia->eme_c_lugar_emergencia?></td>

                        <td class="text-right text-bold bg-primary" >Comunas afectadas</td>
                        <td class="text-left active" ><?php echo comunasEmergenciaConComa($emergencia->eme_ia_id)?></td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold bg-primary" >Tipo Evento</td>
                        <td class="text-left active" ><?php echo nombreEmergenciaTipo($emergencia->tip_ia_id); ?></td>

                        <td class="text-right text-bold bg-primary" >Fecha recepción</td>
                        <td class="text-left active" ><?php echo ISODateTospanish($emergencia->eme_d_fecha_recepcion)?></td>
                    </tr>
                    </tbody>
                </table>

        </div>


    </div>

    <hr/>

    <div class="top-spaced">
        <!-- TAB NAVIGATION -->
        <ul class="nav nav-pills" role="tablist">
            <li class="active">
                <a href="#documentos" role="tab" data-toggle="tab">Documentos</a>
            </li>
            <li>
                <a href="#reportes" role="tab" data-toggle="tab">Reportes</a>
            </li>
            <li><a href="#historial" role="tab" data-toggle="tab">Historial</a></li>
        </ul>
        <!-- TAB CONTENT -->
        <div class="tab-content">
            <div class="active tab-pane fade in small" id="documentos">
                <?php echo emergenciaGrillaDocumento($emergencia->eme_ia_id); ?>
            </div>
            <div class="tab-pane fade small" id="reportes">
                <?php echo emergenciaGrillaReporte($emergencia->eme_ia_id); ?>
            </div>
            <div class="tab-pane fade small" id="historial">
                <?php echo emergenciaGrillaHistorial($emergencia->eme_ia_id); ?>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 text-right top-spaced">
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>
