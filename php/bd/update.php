<?php

$B1000 = "CREATE TABLE sistema(version INTEGER(4) DEFAULT '999') ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1001 = "INSERT INTO sistema VALUES(999);";
$B1002 = "CREATE TABLE usuario(idusuario varchar(10) NOT NULL, login varchar(20) NOT NULL,
  email varchar(100) NOT NULL,
  nombre varchar(100) NOT NULL,
  nit  INTEGER(10),
  ci VARCHAR(12) NOT NULL,
  departamento  VARCHAR(10) NOT NULL,
  sexo varchar(1) NOT NULL,
  estado VARCHAR(9) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY  (idusuario)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1003 = "ALTER TABLE usuario ADD COLUMN seguridad VARCHAR(32) NOT NULL";
$B1004 = "ALTER TABLE usuario ADD COLUMN password VARCHAR(32) NOT NULL";
$B1005 = "CREATE TABLE selkis(seguridad varchar(32) NOT NULL, idusuario varchar(20) NOT NULL,
  url varchar(100) NOT NULL,
  bd varchar(100) NOT NULL,
  estado VARCHAR(9) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY  (url,bd),  KEY url (url),  KEY bd (bd),
  CONSTRAINT selkis_usuario FOREIGN KEY (idusuario) REFERENCES usuario (idusuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1006 = "ALTER TABLE selkis ADD COLUMN idselkis VARCHAR(10) NOT NULL";
$B1007 = "CREATE TABLE categoria(idcategoria varchar(10) NOT NULL, nombre varchar(100) NOT NULL,
  estado varchar(6) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY  (idcategoria),  KEY idcategoria (idcategoria)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1008 = "CREATE TABLE subcategoria(idsubcategoria varchar(10) NOT NULL, idcategoria varchar(10) NOT NULL, nombre varchar(100) NOT NULL,
  estado varchar(6) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY  (idsubcategoria),  KEY idsubcategoria (idsubcategoria),
  CONSTRAINT categoria_subcategoria FOREIGN KEY (idcategoria) REFERENCES categoria (idcategoria) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1009 = "INSERT INTO categoria(idcategoria, nombre, estado) VALUES('cat-1', 'Material Electrico', 'Activo');";
$B1010 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-1', 'cat-1', 'Material Electrico', 'Activo');";
//p.idproducto, idsubcategoria, p.nombre, marca, unidad, bs
// usr-100000pro-100000
$B1011 = "CREATE TABLE producto(idproducto varchar(25) NOT NULL, idsubcategoria varchar(10) NOT NULL, nombre varchar(100) NOT NULL,
  tipo varchar(1) NOT NULL DEFAULT 'S', cantidad Decimal(8,2) NOT NULL, precio Decimal(8,2) NOT NULL, 
  marca VARCHAR(22) NOT NULL, unidad VARCHAR(10) NOT NULL,
  PRIMARY KEY  (idproducto),  KEY idproducto (idproducto),
  CONSTRAINT subcategoria_producto FOREIGN KEY (idsubcategoria) REFERENCES subcategoria (idsubcategoria) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1012 = "ALTER TABLE producto ADD COLUMN idusuario VARCHAR(10) NOT NULL";
$B1013 = "ALTER TABLE producto ADD FOREIGN KEY (idusuario) REFERENCES usuario (idusuario) ON DELETE RESTRICT ON UPDATE RESTRICT";
$B1014 = "ALTER TABLE producto ADD FULLTEXT(nombre, marca);";
$B1015 = "ALTER TABLE usuario ADD COLUMN puntos INTEGER(10)  NOT NULL DEFAULT 0";
$B1016 = "ALTER TABLE usuario ADD COLUMN votos INTEGER(10)  NOT NULL DEFAULT 0";
//Av. de la Heroínas O-555, Edificio ZAMOR
//Teléfono Piloto: 591-4-4 200 911
//Fax: 591-4-458-1992
//info@emelecsrl.com
//Casilla Postal : 4692
//Encuentrenos en Google Maps
$B1017 = "CREATE TABLE sucursal(idsucursal varchar(10) NOT NULL, direccion varchar(100) NOT NULL, telefono varchar(50) NOT NULL,
  fax varchar(50), email VARCHAR(50), casilla VARCHAR(20), 
  maps VARCHAR(100), idusuario VARCHAR(10) NOT NULL,
  PRIMARY KEY  (idsucursal),  KEY idsucursal (idsucursal),
  CONSTRAINT usuario_sucursal FOREIGN KEY (idusuario) REFERENCES usuario (idusuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1018 = "INSERT INTO sucursal VALUES('suc-100000', 'Av. de la Heroínas O-555, Edificio ZAMOR', '4200911', '4581992', 'info@emelecsrl.com', '4692', 'https://www.google.com/maps/place/Emelec+S.R.L./@-17.393475,-66.163493,17z/data=!4m6!1m3!3m2!1s0x93e373f516ce4225:0x8a75dcf8e5dc1b16!2sEmelec+S.R.L.!3m1!1s0x93e373f516ce4225:0x8a75dcf8e5dc1b16', 'usr-100000')";
$B1019 = "INSERT INTO categoria(idcategoria, nombre, estado) VALUES('cat-2', 'Vestimentas y Accesorios', 'Activo');";
$B1020 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-2', 'cat-2', 'Carteras y Bolsos', 'Activo');";
$B1021 = "ALTER TABLE sucursal DROP COLUMN casilla;";
$B1022 = "ALTER TABLE sucursal DROP COLUMN maps;";
$B1023 = "ALTER TABLE sucursal ADD COLUMN latitud VARCHAR(20) DEFAULT '0'";
$B1024 = "ALTER TABLE sucursal ADD COLUMN longitud VARCHAR(20) DEFAULT '0'";
$B1025 = "ALTER TABLE sucursal MODIFY COLUMN idsucursal VARCHAR(25) NOT NULL";
$B1026 = "ALTER TABLE sucursal ADD COLUMN num INTEGER(3)";
$B1027 = "INSERT INTO categoria(idcategoria, nombre, estado) VALUES('cat-3', 'Animales', 'Activo');";
$B1028 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-3', 'cat-3', 'Perritos en adopcion', 'Activo');";
$B1029 = "CREATE TABLE contador(contador INTEGER(10) DEFAULT 1) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1030 = "INSERT INTO contador VALUES(100);";
$B1031 = "ALTER TABLE usuario MODIFY COLUMN nit VARCHAR(15)";
$B1032 = "CREATE TABLE caracteristica(idcaracteristica varchar(7) NOT NULL,
  nombre varchar(20) NOT NULL,
  PRIMARY KEY (idcaracteristica)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1033 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-1', 'interno');";
$B1034 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-2', 'externo');";
$B1035 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-3', 'altura');";
$B1036 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-4', 'altura2');";
$B1037 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-5', 'color');";
$B1038 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-6', 'sexo');";
$B1039 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-7', 'corriente');";
$B1040 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-8', 'voltaje');";
$B1041 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-9', 'tamano');";
$B1042 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-10', 'esterilizado');";
$B1043 = "INSERT INTO caracteristica (idcaracteristica, nombre) VALUES('car-11', 'estado');";
$B1044 = "CREATE TABLE subcar(idsubcategoria varchar(10) NOT NULL, idcaracteristica VARCHAR(7) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1045 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-1', 'car-7');";
$B1046 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-1', 'car-8');";
$B1047 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-3', 'car-5');";
$B1048 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-3', 'car-6');";
$B1049 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-3', 'car-9');";
$B1050 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-3', 'car-10');";
$B1051 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-3', 'car-11');";
$B1052 = "CREATE TABLE procar(idproducto varchar(25) NOT NULL, idcaracteristica VARCHAR(7) NOT NULL, "
        . " KEY idproducto (idproducto), KEY idcaracteristica (idcaracteristica),
  CONSTRAINT carpro_fk_car FOREIGN KEY (idcaracteristica) REFERENCES caracteristica (idcaracteristica),
  CONSTRAINT carpro_fk_pro FOREIGN KEY (idproducto) REFERENCES producto (idproducto)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$B1053 = "ALTER TABLE procar ADD COLUMN valor VARCHAR(50) NOT NULL";
$B1054 = "ALTER TABLE producto ADD COLUMN cimg INTEGER(2) NOT NULL DEFAULT 0";
$B1055 = "ALTER TABLE producto ADD COLUMN fecha DATE NOT NULL";
$B1056 = "ALTER TABLE producto ADD COLUMN hora TIME";
$B1057 = "UPDATE subcategoria SET nombre='Perros Adopcion' WHERE idsubcategoria = 'sub-3';";
$B1058 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-4', 'cat-3', 'Perros Encontrados', 'Activo');";
$B1059 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-5', 'cat-3', 'Perros Extraviados', 'Activo');";
$B1060 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-6', 'cat-3', 'Gatos Adopcion', 'Activo');";
$B1061 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-7', 'cat-3', 'Gatos Encontrados', 'Activo');";
$B1062 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-8', 'cat-3', 'Gatos Extraviados', 'Activo');";
$B1063 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-4', 'car-5');";
$B1064 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-4', 'car-6');";
$B1065 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-4', 'car-9');";
$B1066 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-4', 'car-10');";
$B1067 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-4', 'car-11');";
$B1068 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-5', 'car-5');";
$B1069 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-5', 'car-6');";
$B1070 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-5', 'car-9');";
$B1071 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-5', 'car-10');";
$B1072 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-5', 'car-11');";
$B1073 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-6', 'car-5');";
$B1074 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-6', 'car-6');";
$B1075 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-6', 'car-9');";
$B1076 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-6', 'car-10');";
$B1077 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-6', 'car-11');";
$B1078 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-7', 'car-5');";
$B1079 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-7', 'car-6');";
$B1080 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-7', 'car-9');";
$B1081 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-7', 'car-10');";
$B1082 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-7', 'car-11');";
$B1083 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-8', 'car-5');";
$B1084 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-8', 'car-6');";
$B1085 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-8', 'car-9');";
$B1086 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-8', 'car-10');";
$B1087 = "INSERT INTO subcar(idsubcategoria, idcaracteristica) VALUES('sub-8', 'car-11');";

//$B2990 = "INSERT INTO caracteristica (idcaracteristica, nombre, estado, numero) SELECT * FROM (SELECT 'car-8', 'voltaje', 'Baja', '8') AS tmp WHERE NOT EXISTS (SELECT idcaracteristica FROM caracteristica WHERE idcaracteristica = 'car-8') LIMIT 1;";
//$B2991 = "INSERT INTO caracteristica (idcaracteristica, nombre, estado, numero) SELECT * FROM (SELECT 'car-8', 'voltaje', 'Baja', '8') AS tmp WHERE NOT EXISTS (SELECT idcaracteristica FROM caracteristica WHERE idcaracteristica = 'car-8') LIMIT 1;";
// color, sexo, tamaño y esterilizacion, estado
//$B1031 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-3', 'cat-3', 'Perritos encontrados', 'Activo');";
//$B1032 = "INSERT INTO subcategoria(idsubcategoria, idcategoria, nombre, estado) VALUES('sub-3', 'cat-3', 'Perritos extraviados', 'Activo');";
//$B1011 = "CREATE TABLE imagen(idimagen varchar(20) NOT NULL DEFAULT '',
//  link text,
//  idproducto varchar(25) NOT NULL DEFAULT '',
//  PRIMARY KEY (idimagen),
//  KEY `idproducto` (`idproducto`),
//  CONSTRAINT `imagen_fk_producto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 7168 kB; (`idproducto`) REFER `sistema/producto' 
////$B1007 = "ALTER TABLE selkis ADD PRIMARY KEY  (idselkis) ";
?>