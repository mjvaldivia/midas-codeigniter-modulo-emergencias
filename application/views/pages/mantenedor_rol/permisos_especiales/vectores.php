<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("denuncias", $permiso); ?> name="permiso[denuncias][]" id="establecimientos_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Denuncias
</div>
<div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("trampas", $permiso); ?> name="permiso[trampas][]" id="establecimientos_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Trampas
</div><div class="col-sm-4">
    <input <?php echo checkboxPermisosChecked("denuncias", $permiso); ?> name="permiso[hallazgos][]" id="establecimientos_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
    Hallazgos (Inspecciones)
</div>



