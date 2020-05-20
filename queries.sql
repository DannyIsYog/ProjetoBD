1.

select latitude, longitude, count(*)
from incidencia i left outer join item t on i.item_id=t.id left outer join anomalia a on i.anomalia_id=a.id
group by latitude, longitude
having count(*) <= all (
	select count(*)
	from incidencia i left outer join item t on i.item_id=t.id left outer join anomalia a on i.anomalia_id=a.id
	group by latitude, longitude);

2.

select latitude, longitude
from incidencia i left outer join anomalia a on a.id=i.anomalia_id left outer join anomalia_traducao at on at.id=a.id left outer join item it on it.id=i.item_id
where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59' and tem_anomalia_redacao='f'
group by latitude, longitude
having count(*) >= all (
	select count(*)
	from incidencia i left outer join anomalia a on a.id=i.anomalia_id left outer join anomalia_traducao at on at.id=a.id left outer join item it on it.id=i.item_id
	where ts >= '2020-01-01 00:00:00' and ts <= '2020-06-30 23:59:59' and tem_anomalia_redacao='f'
  group by latitude, longitude);



3.

Select c.email from correcao c natural join proposta_de_correcao
left outer join anomalia a on a.id=c.anomalia_id
left outer join incidencia i on a.id=i.anomalia_id
left outer join item it on it.id=i.item_id
where latitude < 39.336775;


4.

Select i.email
from correcao c join incidencia i on c.anomalia_id = i.anomalia_id
where c.email = i.email;
