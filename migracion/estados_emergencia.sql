CREATE  TABLE `sipresa_dev`.`estados_emergencias` (
  `est_ia_id` INT NOT NULL AUTO_INCREMENT ,
  `est_c_nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`est_ia_id`) );

INSERT INTO `sipresa_dev`.`estados_emergencias` (`est_ia_id`, `est_c_nombre`) VALUES ('1', 'En curso');
INSERT INTO `sipresa_dev`.`estados_emergencias` (`est_ia_id`, `est_c_nombre`) VALUES ('2', 'Cerrada');

ALTER TABLE `sipresa_dev`.`emergencias` ADD COLUMN `est_ia_id` INT NULL  AFTER `for_ia_id` ;
UPDATE sipresa_dev.emergencias SET est_ia_id=1;

