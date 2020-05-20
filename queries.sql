1.

select x1,y1,x2,y2, count(*)
from anomalia
group by x1,y1,x2,y2
having count(*) >= all (
	select count(*)
	from anomalia
	group by x1,y1,x2,y2);

2.

select zona, count(*)
from anomalia natural join anomalia_traducao
group by zona
where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59'
having count(*) <= all (
	select count(*)
	from anomalia join anomalia_traducao
	group by zona
	where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59');



3.

select c.email
from  correcao c natural join incidencia i natural join item m
where latitude < 39.336775;


4.

Select i.email
from correcao c join incidencia i on c.anomalia_id = i.anomalia_id
where c.email = i.email;
