<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("muestra", $permiso); ?> name="permiso[muestra][]" id="finalizar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ingreso de muestra
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("resultados", $permiso); ?> name="permiso[resultados][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ingreso de resultados
</div>


