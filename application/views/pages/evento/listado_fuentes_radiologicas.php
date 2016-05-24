<table class="table table-condensed table-hover table-bordered datatable paginada small">
    <thead>
        <tr>
            <th>Empresa/Establecimiento</th>
            <th>Rut</th>
            <th>Comuna</th>
            <th>Tipo Fuente</th>
            <th>Actividad/Radioactividad</th>
            <th>Nº Serie</th>
            <th>Marca</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado_fuentes as $fuente):?>
        <tr>
            <td class="text-center"><?php echo $fuente['nombre_empresa_fuente']?></td>
            <td class="text-center"><?php echo $fuente['rut_empresa_fuente']?></td>
            <td class="text-center"><?php echo $fuente['comuna_empresa_fuente']?></td>
            <td class="text-center"><?php echo $fuente['tipo_fuente']?></td>
            <td class="text-center"><?php echo $fuente['actividad_fuente']?></td>
            <td class="text-center"><?php echo $fuente['numero_serie_fuente']?></td>
            <td class="text-center"><?php echo $fuente['marca_fuente']?></td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm" onclick="cargarDatosFuente(<?php echo $fuente['id_fuente']?>);"><i class="fa fa-check-square"></i></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<div class="top-spaced text-center">
    <button class="btn btn-primary" type="button" onclick="xModal.close();">Cerrar</button>
</div>