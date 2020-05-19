drop table if exists local_publico cascade;
drop table if exists item cascade;
drop table if exists anomalia cascade;
drop table if exists anomalia_traducao cascade;
drop table if exists duplicado cascade;
drop table if exists utilizador cascade;
drop table if exists utilizador_qualificado cascade;
drop table if exists utilizador_regular cascade;
drop table if exists incidencia cascade;
drop table if exists proposta_de_correcao cascade;
drop table if exists correcao cascade;

create table local_publico
  (
   latitude numeric(9,6) not null,
   longitude numeric(9,6) not null,
   nome varchar(40) not null,
   constraint pk_coordinates primary key(latitude, longitude)
 );

create table item
  (
   id INT not null,
   descricao varchar(100) not null,
   localizacao varchar(40) not null,
   latitude numeric(9,6) not null,
   longitude numeric(9,6) not null,
   constraint pk_item_id primary key(id),
   constraint fk_item_coordinates foreign key(latitude, longitude) references local_publico(latitude, longitude)
  );

create table anomalia
  (
   id INT not null,
   x1 INT not null,
   y1 INT not null,
   x2 INT not null,
   y2 INT not null,
   imagem varchar(100) not null,
   lingua varchar(20) not null,
   ts TIMESTAMP not null,
   descricao varchar(100) not null,
   tem_anomalia_redacao boolean not null,
   constraint pk_anomalia_id primary key(id)
  );

create table anomalia_traducao
  (
   id INT not null,
   x3 INT not null,
   y3 INT not null,
   x4 INT not null,
   y4 INT not null,
   lingua2 varchar(20) not null,
   constraint fk_anomalia_traducao_id foreign key(id) references anomalia(id),
   constraint pk_anomalia_traducao_id primary key(id)
  );

create table duplicado
  (
   id1 INT not null,
   id2 INT not null,
   constraint fk_id1 foreign key(id1) references item(id),
   constraint fk_id2 foreign key(id2) references item(id),
   constraint pk_duplicado_id1_id2 primary key(id1, id2)
  );

create table utilizador
  (
   email varchar(50) not null,
   password varchar(50) not null,
   constraint pk_utilizador_email primary key(email)
  );

create table utilizador_qualificado
  (
   email varchar(50) not null,
   constraint fk_utilizador_qualificado_email foreign key(email) references utilizador(email),
   constraint pk_utilizador_qualificado_email primary key(email)
  );

create table utilizador_regular
  (
   email varchar(50) not null,
   constraint fk_utilizador_regular_email foreign key(email) references utilizador(email),
   constraint pk_utilizador_regular_email primary key(email)
  );

create table incidencia
  (
   anomalia_id INT not null,
   item_id INT not null,
   email varchar(50) not null,
   constraint pk_incidencia_anomalia_id primary key(anomalia_id),
   constraint fk_incidencia_anomalia_id foreign key(anomalia_id) references anomalia(id),
   constraint fk_incidencia_item_id foreign key(item_id) references item(id),
   constraint fk_incidencia_email foreign key(email) references utilizador(email)
  );

create table proposta_de_correcao
  (
   email varchar(50) not null,
   nmr INT not null,
   data_hora TIMESTAMP not null,
   texto varchar(50) not null,
   constraint pk_proposta_de_correcao_email_nmr primary key(email, nmr),
   constraint fk_proposta_de_correcao_email foreign key(email) references utilizador_qualificado(email)
  );

create table correcao
  (
   email varchar(50) not null,
   nmr INT not null,
   anomalia_id INT not null,
   constraint pk_correcao_email_nmr_anomalia_id primary key(email, nmr, anomalia_id),
   constraint fk_correcao_email_nmr foreign key(email, nmr) references proposta_de_correcao(email, nmr),
   constraint fk_correcao_anomalia_id foreign key(anomalia_id) references incidencia(anomalia_id)
  );
