# cambio para giro de alimentos, de combo a text

UPDATE `sipresa_test`.`configuracion_instalaciones` SET `avc_c_tipo`='texto', `avc_c_combo_padre`= null WHERE `avc_ia_id`='2';

UPDATE sipresa_test.valores_instalaciones v 
SET v.val_c_valor_texto = (SELECT a.aux_c_nombre FROM sipresa_test.auxiliar_subtipoinstalacion a WHERE a.aux_ia_id=v.val_c_valor_pk)
WHERE v.avc_ia_id = 2;
