<ul>
    <?php foreach($comunas as $comuna):?>
    <li><?php echo $comuna?>
    <?php endforeach;?>
</ul>

<div class="col-xs-12 text-center">
    <button type="button" class="btn btn-danger btn-square">Eliminar información</button>
    <button type="button" class="btn btn-primary btn-square" onclick="xModal.close();">Cerrar</button>
</div>