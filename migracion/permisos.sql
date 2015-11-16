ALTER TABLE `sipresa_dev`.`roles_vs_permisos` ADD COLUMN `bo_editar` TINYINT(1) NULL DEFAULT 0  AFTER `rvsp_c_nivel_acceso` , ADD COLUMN `bo_eliminar` TINYINT(1) NULL DEFAULT 0  AFTER `bo_editar` ;

# se agregan nuevos modulos a permisos
INSERT INTO `sipresa_dev`.`permisos` (`per_ia_id`, `per_c_modulo`, `per_c_nombre`, `per_c_id_modulo`, `per_c_eliminar`) VALUES ('40', 'Emergencias', 'Gestión de capas', '2', 0);
INSERT INTO `sipresa_dev`.`permisos` (`per_ia_id`, `per_c_modulo`, `per_c_nombre`, `per_c_id_modulo`) VALUES ('41', 'Emergencias', 'Simulación', '2');
INSERT INTO `sipresa_dev`.`permisos` (`per_ia_id`, `per_c_modulo`, `per_c_nombre`, `per_c_id_modulo`) VALUES ('42', 'Emergencias', 'Documentación', '2');

# permisos para administrador para nuevos modulos
INSERT INTO `sipresa_dev`.`roles_vs_permisos` (`rol_ia_id`, `per_ia_id`, `rvsp_c_nivel_acceso`, `bo_editar`, `bo_eliminar`) VALUES ('27', '40', '0', '1', '1');
INSERT INTO `sipresa_dev`.`roles_vs_permisos` (`rol_ia_id`, `per_ia_id`, `rvsp_c_nivel_acceso`, `bo_editar`, `bo_eliminar`) VALUES ('27', '41', '0', '1', '1');
INSERT INTO `sipresa_dev`.`roles_vs_permisos` (`rol_ia_id`, `per_ia_id`, `rvsp_c_nivel_acceso`, `bo_editar`, `bo_eliminar`) VALUES ('27', '42', '0', '1', '1');

# permisos para eliminar y editar para administrador en todos los modulos
UPDATE `sipresa_dev`.`roles_vs_permisos` SET `bo_editar`='1', `bo_eliminar`='1' WHERE `rvsp_ia_id`='1650';
UPDATE `sipresa_dev`.`roles_vs_permisos` SET `bo_editar`='1', `bo_eliminar`='1' WHERE `rvsp_ia_id`='1651';
UPDATE `sipresa_dev`.`roles_vs_permisos` SET `bo_editar`='1', `bo_eliminar`='1' WHERE `rvsp_ia_id`='1819';
UPDATE `sipresa_dev`.`roles_vs_permisos` SET `bo_editar`='1', `bo_eliminar`='1' WHERE `rvsp_ia_id`='1820';
UPDATE `sipresa_dev`.`roles_vs_permisos` SET `bo_editar`='1', `bo_eliminar`='1' WHERE `rvsp_ia_id`='1821';