INSERT INTO `sipresa_dev`.`roles` (`rol_ia_id`, `rol_c_nombre`) VALUES ('44', 'Monitor');
INSERT INTO `sipresa_dev`.`roles_vs_permisos` (`rol_ia_id`, `per_ia_id`, `rvsp_c_nivel_acceso`) VALUES ('44', '7', '0');

INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '1');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '6');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '13');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '7');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '11');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '4');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '10');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '8');
INSERT INTO `sipresa_dev`.`usuarios_vs_oficinas` (`usu_ia_id`, `ofi_ia_id`) VALUES ('2', '9');

INSERT INTO `sipresa_dev`.`usuarios` (`usu_ia_id`, `usu_c_login`, `usu_c_clave`, `usu_c_rut`, `usu_c_nombre`, `usu_c_apellido_paterno`, `usu_c_apellido_materno`, `sex_ia_id`, `usu_c_email`, `reg_ia_id`, `prov_ia_id`, `com_ia_id`, `ofi_ia_id`, `usu_c_telefono`, `crg_ia_id`, `est_ia_id`, `usu_b_email_emergencias`, `usu_b_cre_activo`) VALUES ('2', 'monitor', '21232f297a57a5a743894a0e4a801fc3', '1-1', 'Monitor', 'Test', 'Test', '1', 'vladimir@cosof.cl', '5', '7', '0', '15', '999999', '9', '1', 'NO', '0');
