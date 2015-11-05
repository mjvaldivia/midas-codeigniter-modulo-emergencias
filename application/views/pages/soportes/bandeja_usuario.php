<div class="row">
    
    <div class="col-xs-12">
        <h3 class="page-header">Mensajes de Soporte</h3>
    </div>

    <div class="table-responsive col-xs-12">
        <table class="table table-hover table-condensed table-bordered " id="tabla_soportes">
            <thead>
                <tr>
                    <th># Ticket</th>
                    <th>Fecha</th>
                    <th>Asunto</th>
                    <th>Enviado por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($soportes as $item):?>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <?php endforeach;?>
            </tbody>    
        </table>
    </div>

</div>




<?= loadCSS("assets/lib/DataTables-1.10.8/css/dataTables.bootstrap.css") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/jquery.dataTables.js") ?>
<?= loadJS("assets/lib/DataTables-1.10.8/js/dataTables.bootstrap.js") ?>

<?= loadJS("assets/js/soportes.js") ?>

<script type="text/javascript">
    $(document).ready(function () {
        Soportes.init();
        
    });
</script>