create database pruebaLogin;

use stockcontrol;

select * from users;

create table usuarios(
id int(11) primary key auto_increment,
    Usuario varchar(50),
    Contrasenia varchar(500)
);



create table SpareParts(
id_code int(11) auto_increment primary key not null,
code int(11) not null,
qty int(11) not null,
name varchar(100) not null
);

create table Movements (
id_movement int(11) auto_increment primary key not null,
ci int(12) not null,
code int(12) not null,
move varchar(11) not null,
qty int(11) not null
);

select * from SpareParts;

delimiter //
create procedure SP_AgregarUsuario (in usuario varchar(50), in contrasenia varchar(50))
begin
insert into Usuarios (Usuario, Contrasenia) values (usuario, contrasenia);
end//

delimiter ;

delimiter //
create procedure SP_ValidarUsuario (in username varchar(50), in passw varchar(50))
begin
select * from Usuarios where Usuario=username and Contrasenia=passw;
end//

delimiter ;

select * from usuarios;

use pruebaLogin;

call SP_AgregarUsuario('Fede', 'gay');
call SP_ValidarUsuario ('admin', 'admin');

SELECT * FROM SpareParts LIMIT 10 OFFSET 0

drop procedure SP_ValidarUsuario;