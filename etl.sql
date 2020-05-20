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

--
-- FUNCTION THAT FACTS TABLE
--




Select load_tempo_dim();
Select load_utilizador_dim();
Select load_local_dim();
Select load_language_dim();




Select id_utilizador, id_tempo, id_local, id_lingua
from utilizador u
left outer join d_utilizador d1 on d1.email = u.email
natural join anomalia a left outer join d_tempo d2
on extract(day from a.ts)=d2.dia
and extract(month from a.ts)=d2.mes
and extract(year from a.ts)=d2.ano
left outer join d_lingua d3 on d3.lingua=a.lingua
natural join local_publico lp
left outer join d_local d4 on d4.latitude=lp.latitude and d4.longitude=lp.longitude;
