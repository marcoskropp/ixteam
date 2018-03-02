create database SituacaoDeAprendizagem;
use SituacaoDeAprendizagem;

create table usuario(
idUsuario int not null auto_increment primary key,
nomeUsuario varchar(100),
emailUsuario varchar(100),
senhaUsuario varchar(100),
apelidoUsuario varchar(70),
imagemUsuario varchar(255) default 'padrao-usuario.jpg'
);

create table publicacao(
idPublicacao int not null auto_increment primary key,
textoPublicacao varchar(255), 
imagemPublicacao varchar(255) default 'padrao-publicacao.png',
idUsuario int not null
);

create table chat(
idChat int not null auto_increment primary key,
textoChat varchar(255),
idUsuario int not null,
idAmigo int not null
);

create table relacao(
idRelacao int not null auto_increment primary key,
idUsuario int not null,
idAmigo int not null
);

alter table publicacao add foreign key (idUsuario) references usuario (idUsuario);
alter table chat add foreign key (idUsuario) references usuario (idUsuario);
alter table chat add foreign key (idAmigo) references usuario (idUsuario);
alter table relacao add foreign key (idUsuario) references usuario (idUsuario);
alter table relacao add foreign key (idAmigo) references usuario (idUsuario);