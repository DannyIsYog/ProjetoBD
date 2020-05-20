DROP TABLE IF EXISTS d_utilizador cascade;
DROP TABLE IF EXISTS d_tempo cascade;
DROP TABLE IF EXISTS d_local cascade;
DROP TABLE IF EXISTS d_lingua cascade;
DROP TABLE IF EXISTS f_anomalia cascade;

CREATE TABLE d_utilizador (
  id_utilizador serial NOT NULL,
  email varchar(50) NOT NULL,
  tipo varchar(45) NOT NULL,
  constraint pk_d_utilizador_id_utilizador primary key(id_utilizador)
);

CREATE TABLE d_tempo (
  id_tempo integer NOT NULL,
  dia integer NOT NULL,
  dia_da_semana varchar(45) NOT NULL,
  semana integer NOT NULL,
  mes integer NOT NULL,
  trimestre integer NOT NULL,
  ano integer NOT NULL,
  constraint pk_d_tempo_id_tempo primary key(id_tempo)
);

CREATE TABLE d_local (
  id_local serial NOT NULL,
  latitude numeric(9,6) NOT NULL,
  longitude numeric(9,6) NOT NULL,
  nome varchar(40) NOT NULL,
  constraint pk_d_local_id_local primary key(id_local)
);

CREATE TABLE d_lingua (
  id_lingua serial NOT NULL,
  lingua varchar(80) NOT NULL,
  constraint pk_d_lingua_lingua primary key(id_lingua)
  );

CREATE TABLE f_anomalia (
  id_utilizador serial NOT NULL,
  id_tempo integer NOT NULL,
  id_local integer NOT NULL,
  id_lingua integer NOT NULL,
  tipo_anomalia varchar(80) NOT NULL,
  com_proposta varchar(45) NOT NULL,
  constraint pk_f_anomalia_ids primary key(id_utilizador, id_tempo, id_local, id_lingua),
  constraint fk_f_anomalia_id_utilizador foreign key(id_utilizador) references d_utilizador(id_utilizador),
  constraint fk_f_anomalia_id_tempo foreign key(id_tempo) references d_tempo(id_tempo),
  constraint fk_f_anomalia_id_local foreign key(id_local) references d_local(id_local),
  constraint fk_f_anomalia_id_lingua foreign key(id_lingua) references d_lingua(id_lingua)
);
