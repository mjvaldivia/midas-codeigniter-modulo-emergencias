<li class="panel">
    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#<?= $target ?>">
        <i class="fa <?= $icon_class ?>"></i> <?= $name ?> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="collapse nav <?= $class ?>" id="<?= $target ?>">
        <?= $child ?>
    </ul>
</li>



