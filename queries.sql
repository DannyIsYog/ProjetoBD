1.

select zona, count(*)
from anomalia
group by zona
having count(*) >= all (
	select count(*)
	from anomalia
	group by zona);

2.

select zona, count(*)
from anomalia natural join anomalia_tradução
group by zona
where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59'
having count(*) <= all (
	select count(*)
	from anomalia join anomalia_tradução
	group by zona
	where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59');



3.

select c.email 
from  correção c natural join incidência i natural join item m
where latitude < 39.336775;


4.

select c.email
from correção c natural join incidencia i
where c.email = i.email
 



