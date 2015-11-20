ALTER TABLE `sipresa_dev`.`alertas` ADD COLUMN `ala_c_utm_lat` VARCHAR(20) NULL DEFAULT NULL  AFTER `ala_c_observacion` , ADD COLUMN `ala_c_utm_lng` VARCHAR(20) NULL DEFAULT NULL  AFTER `ala_c_utm_lat` , ADD COLUMN `ala_c_geozone` VARCHAR(20) NULL DEFAULT NULL  AFTER `ala_c_utm_lng` ;

