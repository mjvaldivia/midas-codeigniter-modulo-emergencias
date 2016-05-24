<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("conclusiones", $permiso); ?> name="permiso[conclusiones][]" id="finalizar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ingreso de conclusiones
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("exportar", $permiso); ?> name="permiso[exportar][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Exportar datos
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("visor", $permiso); ?> name="permiso[visor][]" id="visor_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ver en visor
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("datos_personales", $permiso); ?> name="permiso[datos_personales][]" id="datos_personales_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ver datos personales paciente
</div>