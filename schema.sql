create table local_publico
  (
   latitude numeric(2,6),
   longitude numeric(2,6),
   nome varchar(40),
   constraint pk_coordinates primary key(latitude, longitude),
 );

create table item
  (
   id INT,
   descricao varchar(100),
   localizacao varchar(1), -- ??
   latitude varchar(40),
   longitude varchar(40),
   constraint fk_coordinates foreign key(latitude, longitude) references local_publico(latitude, longitude)
  );

create table anomalia
  (
   id INT,
   zona varchar(10), -- ??
   lingua varchar(20),
   ts varchar(20), -- ??
   descricao varchar(100),
   tem_anomalia_redacao boolean,
  );

create table anomalia_traducao
  (
   id INT,
   zona2 varchar(10), --??
   lingua2 varchar(20),
   constraint fk_id foreign key(id) references anomalia(id)
  );

create table duplicado
  (
  --??
  );

create table utilizador
  (
   email varchar(50),
   password varchar(50),
   constraint pk_email primary key(email)
  );

create table utilizador_qualificado
  (
   email varchar(50),
   constraint fk_email foreign key(email) references utilizador(email),
   constraint pk_email primary key(email)
  );

create table utilizador_regular
  (
   email varchar(50),
   constraint fk_email foreign key(email) references utilizador(email),
   constraint pk_email primary key(email)
  );

create table incidencia
  (
   anomalia_id INT,
   item_id INT,
   email varchar(50),
   constraint pk_anomalia_id primary key(anomalia_id),
   constraint fk_anomalia_id foreign key(anomalia_id) references anomalia(id),
   constraint fk_item_id foreign key(item_id) references item(id),
   constraint fk_email foreign key(email) references utilizador(email)
  );

create table proposta_de_correcao
  (
   email varchar(50),
   nmr INT,
   data_hora varchar(50), --??
   texto varchar(50),
   constraint pk_email_nmr primary key(email, nmr),
   constraint fk_email foreign key(email) references utilizador_qualificado(email)
  );

create table correcao
  (
   email varchar(50),
   nmr INT,
   anomalia_id INT,
   constraint pk_email_nmr_anomalia_id primary key(email, nmr, anomalia_id),
   constraint fk_email_nmr foreign key(email, nmr) references proposta_de_correcao(email, nmr),
   constraint fk_anomalia_id foreign key(anomalia_id) references incidencia(anomalia_id)
  );
