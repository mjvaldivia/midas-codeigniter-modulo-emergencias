create table soportes(
    soporte_id int unsigned not null auto_increment primary key,
    soporte_usuario_fk int(11) NOT NULL,
    soporte_region tinyint not null,
    soporte_codigo int not null,
    soporte_fecha_ingreso datetime not null,
    soporte_asunto varchar(1000) not null,
    soporte_estado tinyint(1) unsigned not null default 1,     /* 1: ingresado; 2: en desarrollo; 3: cerrado */
    soporte_email tinyint(1) unsigned not null default 0,   /* si el usuario desea ser avisado al correo cuando se generar una nueva respuesta */
    soporte_fecha_cierre datetime,
    index(soporte_usuario_fk),
    foreign key (soporte_usuario_fk) references usuarios(usu_ia_id)
) engine=InnoDB default charset=utf8 auto_increment=1;



create table soportes_mensajes(
    soportemensaje_id int unsigned not null auto_increment primary key,
    soportemensaje_soporte_fk int unsigned not null,
    soportemensaje_fecha datetime not null,
    soportemensaje_texto longtext not null,
    soportemensaje_usuario_fk int(11) NOT NULL,
    soportemensaje_tipo tinyint(1) unsigned not null, /* 1: cabecera, 2: respuesta */
    soportemensaje_visto_usuario tinyint(1) not null default 0,
    soportemensaje_visto_soporte tinyint(1) not null default 0,
    index(soportemensaje_soporte_fk),
    foreign key (soportemensaje_soporte_fk) references soportes(soporte_id),
    index(soportemensaje_usuario_fk),
    foreign key (soportemensaje_usuario_fk) references usuarios(usu_ia_id)
) engine=InnoDB default charset=utf8 auto_increment=1;



create table soportes_adjuntos(
    soporteadjunto_id int unsigned not null auto_increment primary key,
    soporteadjunto_mensaje_fk int unsigned not null,
    soporteadjunto_nombre varchar(100) not null,
    soporteadjunto_ruta varchar(500) not null,
    soporteadjunto_mime varchar(50) not null,
    soporteadjunto_sha varchar(100) not null,
    index(soporteadjunto_mensaje_fk),
    foreign key (soporteadjunto_mensaje_fk) references soportes_mensajes(soportemensaje_id)
) engine=InnoDB default charset=utf8 auto_increment=1;

-- Adminer 3.6.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '-03:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `estados_emergencias`;
CREATE TABLE `estados_emergencias` (
  `est_ia_id` int(11) NOT NULL AUTO_INCREMENT,
  `est_c_nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`est_ia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `estados_emergencias` (`est_ia_id`, `est_c_nombre`) VALUES
(1,	'En curso'),
(2,	'Cerrada');

-- 2015-11-09 13:23:13