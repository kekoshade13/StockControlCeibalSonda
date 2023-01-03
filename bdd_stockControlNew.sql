create database StockControl;

use stockcontrol;

create table Users (
id_user int(11) not null auto_increment primary key,
nombre_u varchar(35) not null,
nombre varchar(35) not null,
apellido varchar(35) not null,
ci int(11) not null,
pass varchar(250) not null,
class varchar(11),
genero varchar(11),
img_profile varchar(255)
);

create table Movements (
id_movement int(11) auto_increment primary key not null,
nombre varchar(50) not null,
code int(12) not null,
move varchar(11) not null,
qty int(11) not null,
tipoStock int(11) not null,
date date not null,
hora time not null,
fechaTotal datetime not null
);

create table equipos (
id_equipo int(11) primary key auto_increment not null,
name varchar(255) not null
); 

create table SpareParts(
id_code int(11) auto_increment primary key not null,
code int(11) not null,
name varchar(100) not null,
id_equip int(11) not null
);
alter table SpareParts add constraint fk_equipos FOREIGN KEY (`id_equip`) REFERENCES equipos(`id_equipo`);

create table tipostock(
id_stock int(11) primary key auto_increment,
nameTipoStock varchar(255) not null
);

create table spendingtiloreps(
CustomId int(255) not null auto_increment primary key,
Usu varchar(35) not null,
Date datetime not null,
CodRep int(12) not null,
qty int(12) not null
);

create table equipos_repuestos (
id int AUTO_INCREMENT,
repuesto_id int not null,
equipo_id int not null,
primary key(id),
foreign key (repuesto_id) references SpareParts(id_code),
foreign key (equipo_id) references equipos(id_equipo)
);

create table repuestos_estados (
id int auto_increment,
id_repuesto int not null,
id_estado int not null,
qty int(25),
primary key(id),
foreign key (id_repuesto) references SpareParts(id_code),
foreign key (id_estado) references tipoStock(id_stock)
);