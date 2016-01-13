CREATE TABLE capas
(
  cap_ia_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  cap_c_nombre VARCHAR(500) NOT NULL,
  cap_c_geozone_number INT(11) NOT NULL,
  cap_c_geozone_letter VARCHAR(11) NOT NULL,
  ccb_ia_categoria INT(11) NOT NULL,
  cap_c_propiedades TEXT NOT NULL,
  icon_path VARCHAR(200),
  color VARCHAR(7)
) engine=innodb default charset=utf8 auto_increment=1;


CREATE TABLE capas_geometria(
  geometria_id int(11) PRIMARY KEY not null AUTO_INCREMENT,
  geometria_capa int(11) not null,
  geometria_tipo int(1) not null,
  geometria_nombre varchar(100) default null,
  index(geometria_capa),
  foreign key (geometria_capa) references capas(cap_ia_id)
) engine=innodb default charset=utf8 auto_increment=1;


CREATE TABLE capas_puntos_informacion(
  punto_id int(11) PRIMARY KEY not null AUTO_INCREMENT,
  punto_capitem int(11) not null,
  punto_comuna int(11) not null,
  punto_propiedades text not null,
  punto_geometria text not null,
  index(punto_capitem),
  index(punto_comuna),
  foreign key (punto_capitem) references capas_geometria(geometria_id),
  foreign key (punto_comuna) references comunas(com_ia_id)
) engine=innodb default charset=utf8 auto_increment=1;


CREATE TABLE capas_lineas_informacion(
  linea_id int(11) primary key not null auto_increment,
  linea_capitem int(11) not null,
  linea_comuna int(11) not null,
  linea_propiedades text not null,
  linea_geometria text not null,
  index(linea_capitem),
  index(linea_comuna),
  foreign key (linea_capitem) references capas_geometria(geometria_id),
  foreign key (linea_comuna) references comunas(com_ia_id)
) engine=innodb default charset=utf8 auto_increment=1;


CREATE TABLE capas_poligonos_informacion(
  poligono_id int(11) primary key not null auto_increment,
  poligono_capitem int(11) not null,
  poligono_comuna int(11) not null,
  poligono_propiedades text not null,
  poligono_geometria text not null,
  index(poligono_capitem),
  index(poligono_comuna),
  foreign key (poligono_capitem) references capas_geometria(geometria_id),
  foreign key (poligono_comuna) references comunas(com_ia_id)
) engine=innodb default charset=utf8 auto_increment=1;