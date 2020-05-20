1.

select latitude, longitude, count(*)
from incidencia natural join item natural join anomalia
group by latitude, longitude
having count(*) <= all (
	select count(*)
	from anomalia natural join item
	group by latitude, longitude);

2.

select latitude, longitude count(*)
from incidencia natural join anomalia natural join anomalia_traducao natural join item
group by latitude, longitude
where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59'
having count(*) >= all (
	select count(*)
	from incidencia natural join anomalia natural join anomalia_traducao natural join item
	group by latitude, longitude
	where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59');



3.

select c.email
from  correcao c natural join incidencia i natural join item m
where latitude < 39.336775;


4.

Select i.email
from correcao c join incidencia i on c.anomalia_id = i.anomalia_id
where c.email = i.email;
