select tipo, lingua, dia_da_semana, count(tipo_nomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
group by  tipo, lingua, dia_da_semana
UNION
select tipo, day_period, null, count(tipo_nomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
group by  tipo, lingua
UNION
select tipo, null, null, count(tipo_nomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo
group by  tipo
UNION
select null, null, null, count(tipo_nomalia)
from d_utilizador
	natural join d_lingua
	natural join d_tempo;
