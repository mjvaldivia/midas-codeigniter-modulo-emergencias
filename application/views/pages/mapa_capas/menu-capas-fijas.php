<li class="dropdown-header"> OTROS </li>
<li><a id="btn-importar-sidco" href="javascript:void(0)"><input type="checkbox" name="importar_sidco" id="importar_sidco" value="1"/> <i class="fa fa-fire"></i> Sidco - Conaf </a></li>
<?php if(puedeAbrirVisorEmergencia("casos_febriles")) { ?>
<li class="divider"></li>
<li class="dropdown-header"> ISLA DE PASCUA </li>
<li><a id="btn-importar-rapanui-casos" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_casos" id="importar_rapanui_casos" value="1"/> <i class="fa"><img width="20px" src="<?php echo base_url("assets/img/markers/epidemiologico/caso_sospechoso.png") ?>"></i> Casos febriles </a></li>
<li><a id="btn-importar-rapanui-zona" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_zonas" id="importar_rapanui_zonas" value="1"/> <i style="width:20px; text-align: center" class="fa fa-circle-o"></i> Zonas </a></li>
<li><a id="btn-importar-rapanui-embarazadas" href="javascript:void(0)"><input type="checkbox" name="importar_rapanui_embarazo" id="importar_rapanui_embarazo" value="1"/> <i class="fa"><img width="20px" src="<?php echo base_url("assets/img/markers/otros/embarazada.png") ?>"></i> Embarazadas </a></li>
<?php } ?>

