<div data-row="100">
<table id="grilla-emergencia" class="table table-hover datatable paginada hidden">
    <thead>
        <tr>
            <th>Código</th>
            <th width="10%">Fecha ingreso</th>
            <th width="10%">Fecha toma de muestra</th>
            <th width="10%">Recurso</th>
            <th width="20%">Origen</th>
            <th width="15%">Comuna</th>
            <th width="10%">Resultado</th>
            <th width="15%">Estado</th>
            <th width="5%">Opciones</th>				
        </tr>
    </thead>
    <tbody>
        <?php if(count($lista)>0){ ?>
        <?php foreach($lista as $row){ ?>
        <tr>
            <td width="10%">Muestreo N°<?php echo $row["id"]; ?></td>
            <td width="10%"><?php echo $row["fecha_ingreso"]; ?></td>
            <td width="10%"><?php echo $row["fecha_muestra"]; ?></td>
            <td width="10%"><?php echo $row["recurso"]; ?></td>
            <td width="20%"><?php echo $row["origen"]; ?></td>
            <td width="10%" align="center">
                <?php 
                if($row["comuna"]!=""){
                    echo nombreComuna($row["comuna"]);
                } else {
                    echo "------";
                }
                ?>
            </td>
            
            <td width="10%"><?php echo $row["resultado"]; ?></td>
            
            <td width="20%">
                
                <?php
                if($row["resultado"] == "ND") {
                ?>
                <span class="label blue"> No detectado </span>
                <?php } else { ?>
                
                    <?php
                    if(((int)$row["resultado"]) >= 80) {
                    ?>
                    <span class="label red"> Supera </span>
                    <?php } ?>

                    <?php
                    if(((int)$row["resultado"]) < 80 ) {
                    ?>
                    <span class="label green"> No supera </span>
                    <?php } ?>
                <?php } ?>
                
            </td>
            
            <td align="center" width="5%">
                <div style="width: 150px">
                    <?php if(permisoMareaRoja("editar")) { ?>
                    <button onclick="document.location.href='<?php echo base_url("marea_roja_1/editar/?id=" . $row["id"]); ?>'" title="editar" class="btn btn-sm btn-success" type="button" >
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    
                    <?php if(permisoMareaRoja("eliminar")) { ?>
                    <button title="Eliminar" class="btn btn-sm btn-danger caso-eliminar" type="button"  data="<?php echo $row["id"] ?>" href="#" >
                        <i class="fa fa-trash"></i>
                    </button>
                    <?php } ?>

                </div>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>

</div>