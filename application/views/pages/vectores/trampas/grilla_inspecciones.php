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
                <td class="text-center"><?php echo Fechas::formatearHtml($item['fc_fecha_inspeccion']) ?></td>
                <td class="text-center">
                    <?php echo $item['nombre'] . ' ' . $item['apellido_paterno'] . ' ' . $item['apellido_materno'] ?>
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