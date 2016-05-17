<li class="panel">
    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#<?php echo  $target ?>">
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <i class="<?php echo  $icon_class ?>"></i>
            </div>
            <div class="col-lg-8 col-xs-8">
                <?php echo  $name ?>
            </div>
            <div class="col-lg-2 col-xs-2">
                <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </a>
    <ul class="collapse nav <?php echo  $class ?>" id="<?php echo  $target ?>">
        <?php echo  $child ?>
    </ul>
</li>



