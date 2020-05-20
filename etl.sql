--
-- FUNCTION THAT LOADS THE TIME DIMENSION
--

CREATE OR REPLACE FUNCTION load_tempo_dim()
  RETURNS VOID AS
$$
DECLARE date_value TIMESTAMP;
DECLARE id INTEGER;
DECLARE cursor_t cursor for SELECT ts FROM anomalia;
BEGIN
  OPEN cursor_t;
  LOOP
   FETCH cursor_t INTO date_value;
   id := EXTRACT(YEAR FROM date_value) * 10000
       + EXTRACT(MONTH FROM date_value) * 100
       + EXTRACT(DAY FROM date_value);
   EXIT WHEN NOT FOUND;
   IF id NOT IN (SELECT id_tempo FROM d_tempo) then
     INSERT INTO d_tempo(
       id_tempo,
       dia,
       dia_da_semana,
       semana,
       mes,
       trimestre,
       ano
     ) VALUES (
       id,
       CAST(EXTRACT(DAY FROM date_value) AS INTEGER),
       CAST(EXTRACT(ISODOW FROM date_value) AS INTEGER),
       CAST(EXTRACT(WEEK FROM date_value) AS INTEGER),
       CAST(EXTRACT(MONTH FROM date_value) AS INTEGER),
       CAST(EXTRACT(QUARTER FROM date_value) AS INTEGER),
       CAST(EXTRACT(YEAR FROM date_value) AS INTEGER)
     );
  END IF;
  END LOOP;
  CLOSE cursor_t;
END;
$$ LANGUAGE plpgsql;


--
-- FUNCTION THAT LOADS THE USERS DIMENSION
--

CREATE OR REPLACE FUNCTION load_utilizador_dim()
  RETURNS VOID AS
$$
DECLARE tipo_u varchar(45);
DECLARE email_u varchar(50);
DECLARE cursor_u cursor for SELECT email FROM utilizador;
BEGIN
  OPEN cursor_u;
  LOOP
  FETCH cursor_u into email_u;
  EXIT WHEN NOT FOUND;
  IF email_u in (SELECT email from utilizador_regular) then
    tipo_u := 'regular';
  ELSE
    tipo_u := 'qualificado';
  END IF;
  INSERT INTO d_utilizador(
    email,
    tipo
  ) VALUES (
    email_u,
    tipo_u
  );
  END LOOP;
  CLOSE cursor_u;
END;
$$ LANGUAGE plpgsql;

--
-- FUNCTION THAT LOADS THE LOCAL DIMENSION
--

CREATE OR REPLACE FUNCTION load_local_dim()
  RETURNS VOID AS
$$
BEGIN
  INSERT INTO d_local(latitude, longitude, nome)
  SELECT * FROM local_publico;
END;
$$ LANGUAGE plpgsql;

--
-- FUNCTION THAT LOADS THE LANGUAGE DIMENSION
--

CREATE OR REPLACE FUNCTION load_language_dim()
  RETURNS VOID AS
$$
BEGIN
  INSERT INTO d_lingua(lingua)
  SELECT DISTINCT lingua FROM anomalia;
END;
$$ LANGUAGE plpgsql;

Select load_tempo_dim();
Select load_utilizador_dim();
Select load_local_dim();
Select load_language_dim();

--
-- CREATES AUXILIARY VIEWS
--

DROP VIEW IF EXISTS correction;

CREATE VIEW correction(id) AS
Select id
from anomalia
where id in (Select anomalia_id from correcao natural join proposta_de_correcao);

DROP VIEW IF EXISTS temp;

CREATE VIEW temp(email, lingua, ts, localizacao, nome, latitude, longitude, tipo_anomalia, com_proposta) AS
Select email, lingua, ts, localizacao, nome, latitude, longitude, tipo_anomalia,
CASE WHEN (Select count(*) from correction where id=anomalia_id)>0 then 't'
     ELSE 'f'
END AS com_proposta
from (SELECT *,
CASE WHEN tem_anomalia_redacao='t' THEN 'redacao'
     ELSE 'traducao'
END AS tipo_anomalia
FROM (Select ic.email, lingua, ts, tem_anomalia_redacao, localizacao, nome, latitude, longitude, anomalia_id
      from incidencia ic
      left outer join anomalia a on ic.anomalia_id = a.id
      left outer join item it on ic.item_id = it.id
      left outer join utilizador u on ic.email=u.email
      natural join local_publico) temp1) temp2;

--
-- FUNCTION THAT LOADS F_ANOMALIA
--

CREATE OR REPLACE FUNCTION load_f_anomalia()
  RETURNS VOID AS
$$
BEGIN
  INSERT INTO f_anomalia(id_utilizador, id_tempo, id_local, id_lingua, tipo_anomalia, com_proposta)
  Select id_utilizador, id_tempo, id_local, id_lingua, tipo_anomalia, com_proposta
  from temp t left outer join d_utilizador du on du.email=t.email
  left outer join d_tempo dt on
  extract(day from t.ts)=dt.dia and
  extract(month from t.ts)=dt.mes and
  extract(year from t.ts)=dt.ano
  left outer join d_lingua dli on dli.lingua=t.lingua
  left outer join d_local dlo on dlo.latitude=t.latitude and dlo.longitude=t.longitude;
END;
$$ LANGUAGE plpgsql;

SELECT load_f_anomalia();
