CREATE TABLE capas_nuevo
(
  cap_ia_id INT(11) PRIMARY KEY NOT NULL,
  cap_c_nombre VARCHAR(500) NOT NULL,
  cap_c_geozone_number INT(11) NOT NULL,
  cap_c_geozone_letter VARCHAR(11) NOT NULL,
  icon_arch_ia_id INT(11),
  ccb_ia_categoria INT(11) NOT NULL,
  cap_c_propiedades TEXT NOT NULL,
  icon_path VARCHAR(200),
  color VARCHAR(7)
) charset=utf8 AUTO_INCREMENT=1;


CREATE TABLE capas_items(
  capitem_id int(11) PRIMARY KEY not null AUTO_INCREMENT,
  capitem_capa int(11) not null,
  capitem_com int not null,
  capitem_tipo varchar(100) not null
) CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE capas_items_informacion(
  item_id int(11) PRIMARY KEY not null AUTO_INCREMENT,
  item_capitem int(11) not null,
  item_comuna int(11) not null,
  item_data text not null
) CHARSET=utf8 AUTO_INCREMENT=1;

