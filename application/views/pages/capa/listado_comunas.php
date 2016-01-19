<div class="col-xs-12 small">
    <table class="table datatable paginada table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>Comuna</th>
                <th>Provincia</th>
                <th>Región</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($comunas as $comuna):?>
            <tr>
                <td class="text-center"><?php echo $comuna['com_c_nombre']?></td>
                <td class="text-center"><?php echo $comuna['prov_c_nombre']?></td>
                <td class="text-center"><?php echo $comuna['reg_c_nombre']?></td>
            </tr>
        <?php endforeach;?>
            
        </tbody>
    </table>
</div>
<div class="col-xs-12 text-center top-spaced">
    <button type="button" class="btn btn-square btn-primary" onclick="xModal.close();">Cerrar</button>
</div>