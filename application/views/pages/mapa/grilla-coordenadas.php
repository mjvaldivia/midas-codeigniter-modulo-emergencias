<div class="table-responsive" data-row="5" style="width:100%">
    <table data-export="excel" id="tabla-coordenadas" class="table table-hover table-letra-pequena datatable paginada">
        <thead>
            <tr>
                <th> Latitud grados </th>
                <th> Latitud minutos </th>
                <th> Latitud segundos </th>
                <th> Longitud grados </th>
                <th> Longitud minutos </th>
                <th> Longitud segundos </th>
                <th>Decimal Latitud</th>
                <th>Decimal Longitud</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($lista as $puntos) { ?>
        <tr>
            <td align="center"><?php echo $puntos["gms_grados_latitud"] ?></td>
            <td align="center"><?php echo $puntos["gms_minutos_latitud"] ?></td>
            <td align="center"><?php echo $puntos["gms_segundos_latitud"] ?></td>
            
            <td align="center"><?php echo $puntos["gms_grados_longitud"] ?></td>
            <td align="center"><?php echo $puntos["gms_minutos_longitud"] ?></td>
            <td align="center"><?php echo $puntos["gms_segundos_longitud"] ?></td>
            
            <td align="right" width="10%"><?php echo $puntos["decimales_latitud"] ?></td>
            <td align="right" width="10%"><?php echo $puntos["decimales_longitud"] ?></td>
        </tr>
    <?php } ?>
        </tbody>
    </table>
</div>
