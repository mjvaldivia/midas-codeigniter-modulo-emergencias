<table class="table table-hover small" id="grilla-inspecciones">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Usuario</th>
        <th>Hallazgo</th>
        <th>Cantidad</th>
        <th>Observaciones</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($inspecciones): ?>
        <?php foreach ($inspecciones as $item): ?>
            <tr>
                <td class="text-center"><?php echo ISODateTospanish($item['fc_fecha_inspeccion']) ?></td>
                <td class="text-center">
                    <?php echo $item['usu_c_nombre'] . ' ' . $item['usu_c_apellido_paterno'] . ' ' . $item['usu_c_apellido_materno'] ?>
                </td>
                <td class="text-center">
                    <?php if ($item['cd_hallazgo_inspeccion'] == 1): ?>
                        Si
                    <?php else: ?>
                        No
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php echo $item['cd_cantidad_inspeccion'];?>
                </td>
                <td class="text-center">
                    <?php echo $item['gl_observaciones_inspeccion']?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>