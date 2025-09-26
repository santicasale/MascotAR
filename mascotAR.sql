CREATE DATABASE if not exists MascotAR;
USE MascotAR;

CREATE TABLE if not exists usuario_web(
id_user INT not null AUTO_INCREMENT,
f_name varchar(25) not null,
l_name varchar(50) not null,
nick varchar(20) not null,
pass varchar(15) not null,
email varchar(30) not null,
birthday date not null,
PRIMARY KEY (id_user),
CONSTRAINT user_acc UNIQUE (nick,email)
);

CREATE TABLE if not exists newsletter(
id_newsl INT not null AUTO_INCREMENT,
email varchar(30) not null,
PRIMARY KEY (id_newsl),
UNIQUE (email)
);

CREATE TABLE if not exists usuario_presencial(
id_user INT not null AUTO_INCREMENT,
f_name varchar(20) not null,
l_name varchar(50) not null,
email varchar(30) not null,
birthday date not null,
phone INT(10) not null,
PRIMARY KEY (id_user)
);

CREATE TABLE if not exists mascota_especie(
id_pet_species INT not null AUTO_INCREMENT,
pet_species varchar(20) not null,
PRIMARY KEY (id_pet_species)
);

CREATE TABLE if not exists mascota_sexo(
id_pet_sex INT not null AUTO_INCREMENT,
pet_sex varchar(10) not null,
PRIMARY KEY (id_pet_sex)
);

CREATE TABLE if not exists mascota_color(
id_pet_color INT not null AUTO_INCREMENT,
pet_color varchar(20) not null,
PRIMARY KEY (id_pet_color)
);

CREATE TABLE if not exists mascota_edad(
id_pet_age INT not null AUTO_INCREMENT,
pet_age varchar(10) not null,
PRIMARY KEY (id_pet_age)
);

CREATE TABLE if not exists mascota_estado(
id_pet_status INT not null AUTO_INCREMENT,
pet_status varchar(20) not null,
PRIMARY KEY (id_pet_status)
);
    
CREATE TABLE if not exists mascotas(
id_pet INT not null AUTO_INCREMENT,
pet_species INT not null,
pet_name varchar(20) not null,
pet_breed varchar(50),
pet_sex INT not null,
pet_age INT not null,
pet_color1 INT not null,
pet_color2 INT,
pet_stock INT not null DEFAULT '1',
pet_photo varchar(1000),
PRIMARY KEY (id_pet),
FOREIGN KEY (pet_species) REFERENCES mascota_especie(ID_pet_species),
FOREIGN KEY (pet_sex) REFERENCES mascota_sexo(ID_pet_sex),
FOREIGN KEY (pet_age) REFERENCES mascota_edad(ID_pet_age),
FOREIGN KEY (pet_color1) REFERENCES mascota_color(ID_pet_color),
FOREIGN KEY (pet_color2) REFERENCES mascota_color(ID_pet_color),
FOREIGN KEY (pet_stock) REFERENCES mascota_estado(ID_pet_status)
);

CREATE TABLE if not exists donacion_estado(
id_don_status INT not null AUTO_INCREMENT,
don_status varchar(20) not null,
PRIMARY KEY (id_don_status)
);

CREATE TABLE if not exists donaciones(
id_donacion INT not null AUTO_INCREMENT,
monto decimal(15,2) not null,
id_donador INT not null,
fecha date not null DEFAULT CURRENT_DATE(),
donacion_status INT not null DEFAULT '1',
comprobante_mp BLOB,
PRIMARY KEY (id_donacion),
FOREIGN KEY (id_donador) REFERENCES usuario(ID_user),
FOREIGN KEY (donacion_status) REFERENCES donacion_estado(ID_don_status)
);

CREATE TABLE if not exists adopt_estado(
id_adopt_status INT not null AUTO_INCREMENT,
adopt_status varchar(20) not null,
PRIMARY KEY (id_adopt_status)
);

CREATE TABLE if not exists adopciones(
id_adopt INT not null AUTO_INCREMENT,
id_pet_adopt INT not null,
id_web_adopt INT,
id_local_adopt INT,
fecha date not null DEFAULT CURRENT_DATE(),
adopcion_status INT not null DEFAULT '1',
PRIMARY KEY (id_adopt),
FOREIGN KEY (id_pet_adopt) REFERENCES mascotas(ID_pet),
FOREIGN KEY (id_web_adopt) REFERENCES usuario_web(ID_user),
FOREIGN KEY (id_local_adopt) REFERENCES usuario_presencial(ID_user),
FOREIGN KEY (adopcion_status) REFERENCES adopt_estado(ID_adopt_status)
);

INSERT INTO donacion_estado (don_status) VALUES
('PENDIENTE'),
('APROBADA'),
('CANCELADA');

INSERT INTO adopt_estado (adopt_status) VALUES
('PENDIENTE'),
('APROBADA'),
('CANCELADA');

INSERT INTO mascota_sexo (pet_sex) VALUES
('MACHO'),
('HEMBRA');

INSERT INTO mascota_especie (pet_species) VALUES
('PERRO'),
('GATO'),
('TORTUGA'),
('CANARIO');

INSERT INTO  mascota_edad (pet_age) VALUES
('CACHORRO'),
('ADULTO');

INSERT INTO mascota_color (pet_color) VALUES
('blanco'), 
('negro'), 
('marrón'), 
('amarillo'), 
('naranja'), 
('gris'), 
('otros');

INSERT INTO mascota_estado (pet_status) VALUES
('DISPONIBLE'),
('RESERVADO'),
('ADOPTADO');


