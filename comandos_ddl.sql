create database if not exists rede_social;
use rede_social;

create table if not exists usuario (
    usuario_id serial,
    usuario_nome varchar(100) unique not null,
    usuario_email varchar(100) unique not null,
    usuario_senha varchar(100) not null,
    usuario_cidade varchar(50),
    usuario_pais varchar(50),
    usuario_data_nascimento date,
    usuario_foto_url varchar(255),
    primary key (usuario_id)
);

create table if not exists comunidade (
    comunidade_id serial,
    comunidade_nome varchar(100) unique not null,
    comunidade_descricao varchar(255),
    comunidade_foto_url varchar(255),
    id_usuario bigint unsigned not null,
    data_criacao date not null,
    primary key (comunidade_id),
    foreign key (id_usuario) references usuario(usuario_id)
);

create table if not exists artigo (
    artigo_id serial,
    artigo_titulo varchar(100) not null,
    artigo_descricao varchar(255),
    artigo_gostos int unsigned,
    artigo_desgostos int unsigned,
    artigo_texto varchar(1000) not null,
    primary key (artigo_id)
);

create table if not exists foto (
    foto_id serial,
    foto_titulo varchar(100) not null,
    foto_descricao varchar(255),
    foto_gostos int unsigned,
    foto_desgostos int unsigned,
    foto_url varchar(255) not null,
    primary key (foto_id)
);

create table if not exists video (
    video_id serial,
    video_titulo varchar(100) not null,
    video_descricao varchar(255),
    video_gostos int unsigned,
    video_desgostos int unsigned,
    video_url varchar(255) not null,
    video_duracao int,
    primary key (video_id)
);

create table if not exists mensagem (
    mensagem_id serial,
    mensagem_texto varchar(500) not null,
    primary key (mensagem_id)
);

create table if not exists comentario (
    comentario_id serial,
    comentario_texto varchar(500) not null,
    comentario_gostos int unsigned,
    comentario_desgostos int unsigned,
    primary key (comentario_id)
);


create table if not exists usuario_usuario (
    id_usuario_seguidor bigint unsigned not null,
    id_usuario_seguido bigint unsigned not null,
    primary key (id_usuario_seguidor, id_usuario_seguido),
    foreign key (id_usuario_seguidor) references usuario(usuario_id),
    foreign key (id_usuario_seguido) references usuario(usuario_id)
);

create table if not exists usuario_comunidade (
    id_usuario bigint unsigned not null,
    id_comunidade bigint unsigned not null,
    primary key (id_usuario, id_comunidade),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_comunidade) references comunidade(comunidade_id)
);

create table if not exists usuario_usuario_mensagem (
    id_usuario_emissor bigint unsigned not null,
    id_usuario_receptor bigint unsigned not null,
    id_mensagem bigint unsigned unique not null,
    data_envio datetime not null,
    primary key (id_usuario_emissor, id_usuario_receptor, id_mensagem),
    foreign key (id_usuario_emissor) references usuario(usuario_id),
    foreign key (id_usuario_receptor) references usuario(usuario_id),
    foreign key (id_mensagem) references mensagem(mensagem_id)
);

create table if not exists usuario_artigo_comunidade (
    id_usuario bigint unsigned not null,
    id_artigo bigint unsigned unique not null,
    id_comunidade bigint unsigned not null,
    data_publicacao datetime not null,
    primary key (id_usuario, id_artigo, id_comunidade),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_artigo) references artigo(artigo_id),
    foreign key (id_comunidade) references comunidade(comunidade_id)
);

create table if not exists usuario_foto_comunidade (
    id_usuario bigint unsigned not null,
    id_foto bigint unsigned unique not null,
    id_comunidade bigint unsigned not null,
    data_publicacao datetime not null,
    primary key (id_usuario, id_foto, id_comunidade),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_foto) references foto(foto_id),
    foreign key (id_comunidade) references comunidade(comunidade_id)
);

create table if not exists usuario_video_comunidade (
    id_usuario bigint unsigned not null,
    id_video bigint unsigned unique not null,
    id_comunidade bigint unsigned not null,
    data_publicacao datetime not null,
    primary key (id_usuario, id_video, id_comunidade),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_video) references video(video_id),
    foreign key (id_comunidade) references comunidade(comunidade_id)
);

create table if not exists usuario_comentario_artigo (
    id_usuario bigint unsigned not null,
    id_comentario bigint unsigned unique not null,
    id_artigo bigint unsigned not null,
    data_escrita datetime not null,
    primary key (id_usuario, id_comentario, id_artigo),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_comentario) references comentario(comentario_id),
    foreign key (id_artigo) references artigo(artigo_id)
);

create table if not exists usuario_comentario_foto (
    id_usuario bigint unsigned not null,
    id_comentario bigint unsigned unique not null,
    id_foto bigint unsigned not null,
    data_escrita datetime not null,
    primary key (id_usuario, id_comentario, id_foto),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_comentario) references comentario(comentario_id),
    foreign key (id_foto) references foto(foto_id)
);

create table if not exists usuario_comentario_video (
    id_usuario bigint unsigned not null,
    id_comentario bigint unsigned unique not null,
    id_video bigint unsigned not null,
    data_escrita datetime not null,
    primary key (id_usuario, id_comentario, id_video),
    foreign key (id_usuario) references usuario(usuario_id),
    foreign key (id_comentario) references comentario(comentario_id),
    foreign key (id_video) references video(video_id)
);