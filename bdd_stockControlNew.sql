create database StockControl;
use StockControl;

create table Users (
id_user int(11) not null auto_increment primary key,
nombre_u varchar(35) not null,
ci int(11) not null,
pass varchar(250) not null,
class varchar(11)
);

drop table Users;

create table Movements (
id_movement int(11) auto_increment primary key not null,
nombre varchar(50) not null,
code int(12) not null,
move varchar(11) not null,
qty int(11) not null,
date datetime not null
);

create table SpareParts(
id_code int(11) auto_increment primary key not null,
code int(11) not null,
qty int(11) not null,
name varchar(100) not null
);

insert into Movements (ci, code, move, qty, date) values (54211237, 121242, "Salida", 1, current_timestamp());
use stockcontrol;
select * from Movements;

select * from SpareParts;

update spareparts set qty = qty + 1 where code = 120036;
select * from Users;

select distinct code, count(qty) as Cantidad from Movements where nombre='admin'
and date >= '2022-10-01' and date < '2022-10-06' and move = 'Salida'
group by code
order by code asc;