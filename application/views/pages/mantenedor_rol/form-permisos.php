<form id="form-permisos" name="form_permisos" enctype="application/x-www-form-urlencoded" action="" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $id_rol; ?>"/>

    <?php foreach($lista as $row){ ?>
    <div class="col-lg-6">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-list-ul"></i> <?php echo $row["per_c_nombre"] ?></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body" style='height: 100px'>
                <div class="row"> 
                    <?php if($row["per_ia_id"] != Modulo_Model::SUB_CASOS_FEBRILES) { ?>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedVer($id_rol, $row["per_ia_id"]); ?> data-rel="<?php echo $row["per_ia_id"] ?>" name="ver[]" id="ver_<?php echo $row["per_ia_id"] ?>" class="ver" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Ver
                    </div>
                    <div id="permisos_io_<?php echo $row["per_ia_id"] ?>">
                        <?php if($row["per_ia_id"] != Modulo_Model::SUB_SIMULACION) { ?>
                        
                            
                            <div class="col-sm-4">
                                <input <?php echo permisoFormCheckedEditar($id_rol, $row["per_ia_id"]); ?> name="editar[]" id="editar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                Editar
                            </div>
                            <div class="col-sm-4">
                                <input <?php echo permisoFormCheckedEliminar($id_rol, $row["per_ia_id"]); ?> name="eliminar[]" id="eliminar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                Eliminar
                            </div>
                    
                        
                            <?php if($row["per_ia_id"] == Modulo_Model::SUB_MODULO_ALARMA) { ?>
                                <div class="col-sm-4">
                                    <input <?php echo permisoFormCheckedActivarAlarma($id_rol, $row["per_ia_id"]); ?> name="activar_alarma[]" id="activar_alarma_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                    Activar alarma
                                </div>
                            <?php } ?>
                        
                            <?php if($row["per_ia_id"] == Modulo_Model::SUB_MODULO_EMERGENCIA) { ?>
                   
                                <div class="col-sm-4">
                                    <input <?php echo permisoFormCheckedFinalizar($id_rol, $row["per_ia_id"]); ?> name="finalizar[]" id="finalizar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                    Finalizar emergencia
                                </div>
                                <div class="col-sm-4">
                                    <input <?php echo permisoFormCheckedReporteEmergencia($id_rol, $row["per_ia_id"]); ?> name="reporte[]" id="reporte_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                    Generar reporte
                                </div>
                                <div class="col-sm-4">
                                    <input <?php echo permisoFormCheckedVisorEmergencia($id_rol, $row["per_ia_id"]); ?> name="visor[]" id="visor_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                    Abrir visor
                                </div>
                                <div class="col-sm-4">
                                    <input <?php echo permisoFormCheckedVisorEmergenciaGuardar($id_rol, $row["per_ia_id"]); ?> name="visor_guardar[]" id="visor_guardar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                                    Guardar visor
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" data-rel="<?php echo $row["per_ia_id"] ?>" name="ver[]" id="ver_<?php echo $row["per_ia_id"] ?>" value="<?php echo $row["per_ia_id"] ?>" />
                    
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedActivarAlarma($id_rol, $row["per_ia_id"]); ?> data-rel="<?php echo $row["per_ia_id"] ?>" name="activar_alarma[]" id="ver_<?php echo $row["per_ia_id"] ?>" class="ver" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Ingresar
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedEditar($id_rol, $row["per_ia_id"]); ?> name="editar[]" id="editar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Editar
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedEliminar($id_rol, $row["per_ia_id"]); ?> name="eliminar[]" id="eliminar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Eliminar
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedFinalizar($id_rol, $row["per_ia_id"]); ?> name="finalizar[]" id="finalizar_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Ingreso de conclusiones
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedReporteEmergencia($id_rol, $row["per_ia_id"]); ?> name="reporte[]" id="reporte_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Exportar datos
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedVisorEmergencia($id_rol, $row["per_ia_id"]); ?> name="visor[]" id="visor_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Ver en visor
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedFormularioDatosPersonales($id_rol, $row["per_ia_id"]); ?> name="datos_personales[]" id="datos_personales_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Ver datos personales paciente
                    </div>
                    <div class="col-sm-4">
                        <input <?php echo permisoFormCheckedEmbarazada($id_rol, $row["per_ia_id"]); ?> name="embarazadas[]" id="embarazadas_<?php echo $row["per_ia_id"] ?>" type="checkbox" value="<?php echo $row["per_ia_id"] ?>">
                        Embarazadas
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
    <?php } ?>
    <div class="clearfix"></div>
</form>

