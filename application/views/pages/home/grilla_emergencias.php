<div class="col-lg-12" data-row="5">
    <table id="grilla-emergencia" class="table table-striped datatable paginada hidden">
        <thead>
            <tr>
                <th>Nombre emergencia</th>
                <th>Tipo emergencia</th>
                <th>Comunas afectadas</th>
                <th>Fecha emergencia</th>
                <th>Lugar</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $row){ ?>
            <tr>
                <td><?php echo $row["eme_c_nombre_informante"]; ?></td>
                <td><?php echo nombreEmergenciaTipo($row["tip_ia_id"]); ?> </td>
                <td><?php echo comunasEmergenciaConComa($row["eme_ia_id"]); ?></td>
                <td><?php echo ISODateTospanish($row["eme_d_fecha_emergencia"]); ?></td>
                <td><?php echo $row["eme_c_lugar_emergencia"]; ?></td>
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