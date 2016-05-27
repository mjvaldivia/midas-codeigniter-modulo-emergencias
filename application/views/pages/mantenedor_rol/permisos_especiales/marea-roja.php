<div class="col-lg-12 top-spaced">
    <div class="tile blue">

        <div class="col-sm-6">
            <input <?php echo checkboxPermisosChecked("muestra", $permiso); ?> name="permiso[muestra][]" id="finalizar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
            Ingreso de muestra
        </div>
        <div class="col-sm-6">
            <input <?php echo checkboxPermisosChecked("muestra_con_resultado", $permiso); ?> name="permiso[muestra_con_resultado][]" id="finalizar_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
            Ingreso de muestra con resultados
        </div>
        <div class="col-sm-6">
            <input <?php echo checkboxPermisosChecked("derivar", $permiso); ?> name="permiso[derivar][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
            Derivar muestra
        </div>
        <div class="col-sm-6">
            <input <?php echo checkboxPermisosChecked("resultados", $permiso); ?> name="permiso[resultados][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
            Ingreso de resultados
        </div>
        <div class="col-sm-6">
            <input <?php echo checkboxPermisosChecked("validar", $permiso); ?> name="permiso[validar][]" id="reporte_<?php echo $id_modulo ?>" type="checkbox" value="<?php echo $id_modulo ?>">
            Validar resultados
        </div>
    </div>
</div>