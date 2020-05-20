select tipo, lingua, dia_da_semana, count(tipo_anomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
  natural join f_anomalia
group by  tipo, lingua, dia_da_semana
UNION
select tipo, lingua, null, count(tipo_anomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
  natural join f_anomalia
group by  tipo, lingua
UNION
select tipo, null, null, count(tipo_anomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
  natural join f_anomalia
group by  tipo
