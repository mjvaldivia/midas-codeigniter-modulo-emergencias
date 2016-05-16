<div class="table-responsive" data-row="5" style="width:100%">
    <table data-export="excel" id="tabla-coordenadas" class="table table-hover table-letra-pequena datatable paginada">
        <thead>
            <tr>
                <th>Latitud</th>
                <th>Longitud</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($lista as $puntos) { ?>
        <tr>
            <td><?php echo $puntos["latitud"] ?></td>
            <td><?php echo $puntos["longitud"] ?></td>
        </tr>
    <?php } ?>
        </tbody>
    </table>
</div>
