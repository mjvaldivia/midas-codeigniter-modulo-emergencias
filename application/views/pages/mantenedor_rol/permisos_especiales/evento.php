<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("finalizar", $permiso); ?> name="permiso[finalizar][]" id="finalizar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Finalizar emergencia
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("reporte", $permiso); ?> name="permiso[reporte][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Generar reporte
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("visor", $permiso); ?> name="permiso[visor][]" id="visor_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ver en visor
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("guardar", $permiso); ?> name="permiso[guardar][]" id="guardar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Guardar
</div>

