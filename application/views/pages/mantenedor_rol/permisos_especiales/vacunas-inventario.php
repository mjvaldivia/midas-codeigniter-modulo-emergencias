<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("establecimientos", $permiso); ?> name="permiso[establecimientos][]" id="establecimientos_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Mantenedor de establecimientos
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("ingreso_acta_entrega", $permiso); ?> name="permiso[ingreso_acta_entrega][]" id="ingreso_acta_entrega_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ingreso acta de entrega de establecimientos
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("ingreso_acta_existencias", $permiso); ?> name="permiso[ingreso_acta_existencias][]" id="ingreso_acta_entrega_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Ingreso acta de existencias
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("validar_acta_entrega", $permiso); ?> name="permiso[validar_acta_entrega][]" id="validar_acta_entrega_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Validar acta de entrega
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("validar_acta_entrega_camara_frio", $permiso); ?> name="permiso[validar_acta_entrega_camara_frio][]" id="validar_acta_entrega_camara_frio<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Validar acta de entrega cámara frío
</div>


