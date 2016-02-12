<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <div class="row">
            <div class="col-xs-12">
            <legend><small> TOTALES </small></legend>
            </div>
        </div>
        <?php foreach($totales as $tipo => $valor) { ?>
        <div class="tile gray">
            <div class="row">
                <div class="col-xs-6 text-right">
                    <strong><?php echo $tipo; ?>:</strong>
                </div> 
                <div class="col-xs-6">
                    <?php echo $valor; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>