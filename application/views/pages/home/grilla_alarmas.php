<div class="col-lg-12" data-row="5">
    <table id="grilla-alarmas" class="table table-striped datatable paginada hidden">
        <thead>
            <tr>
                <th>Nombre alarma</th>
                <th>Tipo alarma</th>
                <th>Comunas afectadas</th>
                <th>Fecha alarma</th>
                <th>Lugar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td><?php echo $row["ala_c_nombre_emergencia"]; ?></td>
                <td><?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> </td>
                <td><?php echo comunasAlarmaConComa($row["ala_ia_id"]); ?></td>
                <td><?php echo ISODateTospanish($row["ala_d_fecha_emergencia"]); ?></td>
                <td><?php echo $row["ala_c_lugar_emergencia"]; ?></td>
                <td>
                    <button class="btn btn-xs btn-blue">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>