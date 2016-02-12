<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <legend><small> TOTALES </small></legend>
        <?php foreach($totales as $tipo => $valor) { ?>
        <div class="tile gray">
            <div class="col-xs-6 text-right">
                <strong><?php echo $tipo; ?>:</strong>
            </div> 
            <div class="col-xs-6">
                <?php echo $valor; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>