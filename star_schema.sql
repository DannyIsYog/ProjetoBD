DROP TABLE IF EXISTS d_utilizador;

CREATE TABLE d_utilizador (
  id_utilizador integer NOT NULL,
  email varchar(50) NOT NULL,
  tipo varchar(45) NOT NULL
);

DROP TABLE IF EXISTS d_tempo;

CREATE TABLE d_tempo (
  id_tempo integer NOT NULL,
  dia integer NOT NULL,
  dia_da_semana varchar(45) NOT NULL,
  semana integer NOT NULL,
  mes integer NOT NULL,
  trimestre integer NOT NULL,
  ano integer NOT NULL
);

DROP TABLE IF EXISTS d_local;

CREATE TABLE d_local (
  id_local integer NOT NULL,
  latitude numeric(9,6) NOT NULL,
  longitude numeric(9,6) NOT NULL,
  nome varchar(80) NOT NULL
);

DROP TABLE IF EXISTS d_lingua;

CREATE TABLE d_lingua (
  id_lingua integer NOT NULL,
  lingua varchar(80) NOT NULL
  );

DROP TABLE IF EXISTS f_anomalia;

CREATE TABLE f_anomalia (
  id_utilizador integer NOT NULL,
  id_tempo integer NOT NULL,
  id_local integer NOT NULL,
  id_lingua integer NOT NULL,
  tipo_nomalia varchar(80) NOT NULL,
  com_proposta varchar(45) NOT NULL
);
