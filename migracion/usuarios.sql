

ALTER TABLE `emergencias`.`usuarios_vs_ambitos` RENAME TO  `emergencias`.`usuarios_ambitos` ;

DELETE FROM emergencias.usuarios_ambitos WHERE usu_ia_id not in (select usu_ia_id FROM usuarios);

ALTER TABLE `emergencias`.`usuarios_ambitos` 
  ADD CONSTRAINT `fk_usuarios_ambitos_usuario`
  FOREIGN KEY (`usu_ia_id` )
  REFERENCES `emergencias`.`usuarios` (`usu_ia_id` )
  ON DELETE CASCADE
  ON UPDATE CASCADE
, ADD INDEX `fk_usuarios_ambitos_usuario_idx` (`usu_ia_id` ASC) ;

ALTER TABLE `emergencias`.`usuarios_ambitos` 
  ADD CONSTRAINT `fk_usuarios_ambitos_ambitos`
  FOREIGN KEY (`amb_ia_id` )
  REFERENCES `emergencias`.`ambitos` (`amb_ia_id` )
  ON DELETE CASCADE
  ON UPDATE CASCADE
, ADD INDEX `fk_usuarios_ambitos_ambitos_idx` (`amb_ia_id` ASC) ;

CREATE  TABLE `emergencias`.`usuarios_region` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_usuario` INT NULL ,
  `id_region` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuarios_region_usuarios_idx` (`id_usuario` ASC) ,
  INDEX `fk_usuarios_region_region_idx` (`id_region` ASC) ,
  CONSTRAINT `fk_usuarios_region_usuarios`
    FOREIGN KEY (`id_usuario` )
    REFERENCES `emergencias`.`usuarios` (`usu_ia_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_region_region`
    FOREIGN KEY (`id_region` )
    REFERENCES `emergencias`.`regiones` (`reg_ia_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

/* ejecutar migracion/usuarios_region aqui */

ALTER TABLE `emergencias`.`usuarios` DROP COLUMN `com_ia_id` , DROP COLUMN `prov_ia_id` , DROP COLUMN `reg_ia_id` , ADD COLUMN `usuarioscol` VARCHAR(45) NULL  AFTER `usu_b_cre_activo` 
, DROP INDEX `com_ia_id` 
, DROP INDEX `prov_ia_id` 
, DROP INDEX `reg_ia_id` ;