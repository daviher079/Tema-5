create database if not exists tiendaOnline;
use tiendaOnline;


create table perfil (
	codigo char(5) primary key,
	descripcion varchar(30)
) engine=innodb;

create table usuarios (
	usuario char(20) primary key,
	clave char(40) not null,
	nombre varchar(75) not null,
	correo varchar(75) not null,
	fechaNacimiento date not null,
	perfil char(5) not null,
	index (perfil),
	foreign key (perfil) references perfil (codigo)
) engine=innodb;

create table paginas (
	codigo char(5) primary key,
	descripcion varchar(50),
	url varchar(75) not null
) engine=innodb;

create table accede (
	codigoPerfil char(5) not null,
	codigoPagina char(5) not null,
	index(codigoPerfil),
	index(codigoPagina),
	primary key (codigoPerfil,codigoPagina),
	foreign key (codigoPerfil) references perfil (codigo),
	foreign key (codigoPagina) references paginas (codigo)
) engine=innodb;

create table productos (
	codigoProducto char(5) primary key,
	descripcion varchar(30),
	precio decimal(5,2) not null,
	stock integer not null,
	imagenAlta char(60),
	imagenBaja char(80) 
) engine=innodb;

create table venta (
	idVenta integer not null auto_increment,
	usuarioNickV char(20) not null,
	fechaCompra date not null,
	codigoProductoV char(5) not null,
	cantidad integer not null,
	precioTotal decimal(5,2) not null,	
	index(usuarioNickV),
	primary key(idVenta),
	foreign key (usuarioNickV) references usuarios (usuario),
	foreign key (codigoProductoV) references productos (codigoProducto)
) engine=innodb;

create table albaran (
	idAlbaran integer not null auto_increment,
	fechaAlbaran date not null,
	codigoProductoA char(5) not null,
	cantidad integer not null,
	usuarioNickA char(20) not null,
	index(usuarioNickA),
	primary key (idAlbaran),
	foreign key (codigoProductoA) references productos (codigoProducto),
	foreign key (usuarioNickA) references usuarios (usuario)
) engine=innodb;

insert into perfil (codigo, descripcion) values ('ADM01','Administrador');
insert into perfil (codigo, descripcion) values ('MOD01','Moderador');
insert into perfil (codigo, descripcion) values ('USR01','Usuario');

insert into usuarios (usuario,clave, nombre, correo, fechaNacimiento, perfil) values ('admin','356a192b7913b04c54574d18c28d46e6395428ab','Alfredo Ginés Areces','aga@correo.es','1996/12/29','ADM01');
insert into usuarios (usuario,clave, nombre, correo, fechaNacimiento, perfil) values ('mod','da4b9237bacccdf19c0760cab7aec4a8359010b0','Javier Gracia Cubo','jgc@correo.es','1989/10/23','MOD01');
insert into usuarios (usuario,clave, nombre, correo, fechaNacimiento, perfil) values ('user','77de68daecd823babbb58edb1c8e14d7106e83bb','Lucia Romera Ganso','lrg@correo.es','1978/03/23','USR01');

insert into paginas (codigo,descripcion,url) values ('PAG01','Logout','logout.php');
insert into paginas (codigo,descripcion,url) values ('PAG02','Modificar perfil','modificarPerfil.php');
insert into paginas (codigo,descripcion,url) values ('PAG03','Lista de Deseos','listaDeseos.php');
insert into paginas (codigo,descripcion,url) values ('PAG04','Insertar productos','insertarProductos.php');
insert into paginas (codigo,descripcion,url) values ('PAG05','Modificar productos','modificarProductos.php');
insert into paginas (codigo,descripcion,url) values ('PAG06','Mostrar ventas','mostrarVentas.php');
insert into paginas (codigo,descripcion,url) values ('PAG07','Mostrar albaranes','mostrarAlbaranes.php');

insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG01');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG02');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG03');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG04');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG05');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG06');
insert into accede (codigoPerfil,codigoPagina) values ('ADM01','PAG07');

insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG01');
insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG02');
insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG03');
insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG04');
insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG06');
insert into accede (codigoPerfil,codigoPagina) values ('MOD01','PAG07');

insert into accede (codigoPerfil,codigoPagina) values ('USR01','PAG01');
insert into accede (codigoPerfil,codigoPagina) values ('USR01','PAG02');
insert into accede (codigoPerfil,codigoPagina) values ('USR01','PAG03');

insert into productos (codigoProducto, descripcion, precio, stock, imagenAlta, imagenBaja) values ('PRO01','Camisa de Rayas', 55.23, 40, 'imagen01.png', 'imagen01Baja.png');
insert into productos (codigoProducto, descripcion, precio, stock, imagenAlta, imagenBaja) values ('PRO02','Camiseta azul', 23.45, 22, 'imagen02.png', 'imagen02Baja.png');
insert into productos (codigoProducto, descripcion, precio, stock, imagenAlta, imagenBaja) values ('PRO03','Abrigo verde', 110.32, 60, 'imagen03.png', 'imagen03Baja.png');
insert into productos (codigoProducto, descripcion, precio, stock, imagenAlta, imagenBaja) values ('PRO04','Pantalones vaqueros', 60.30, 78, 'imagen04.png', 'imagen04Baja.png');
insert into productos (codigoProducto, descripcion, precio, stock, imagenAlta, imagenBaja) values ('PRO05','Zapatillas Moradas', 100.45, 60, 'imagen05.png', 'imagen05Baja.png');






