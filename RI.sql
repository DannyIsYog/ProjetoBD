drop trigger if exists email_utilizador_regular_trigger on utilizador_regular;

create or replace function email_utilizador_regular_verifier()
  returns trigger as
$$
begin
  if new.email in (Select email from utilizador_qualificado) then
    raise exception 'Este Utilizador já é um utilizador qualificado.';
  end if;

  return new;
end;
$$ language plpgsql;

create trigger email_utilizador_regular_trigger
before insert on utilizador_regular
for each row execute procedure email_utilizador_regular_verifier();

drop trigger if exists email_verifier_trigger on utilizador_qualificado;

create or replace function email_utilizador_qualificado_verifier()
  returns trigger as
$$
begin
  if new.email in (Select email from utilizador_regular) then
    raise exception 'Este Utilizador já é um utilizador regular.';
  end if;

  return new;
end;
$$ language plpgsql;

create trigger email_utilizador_qualificado_trigger
before insert on utilizador_qualificado
for each row execute procedure email_utilizador_qualificado_verifier();

drop trigger if exists zona_sobreposta_trigger on anomalia_traducao;

create or replace function zona_sobreposta()
  returns trigger as
$$
begin
  if new.x3 >= all (Select x1 from anomalia where id=new.id) and new.x3 <= all (Select x2 from anomalia where id=new.id) then
    if new.y3 >= all (Select y1 from anomalia where id=new.id) and new.y3 <= all (Select y2 from anomalia where id=new.id) then
      return null;
    end if;
  end if;
  if new.x4 >= all (Select x1 from anomalia where id=new.id) and new.x4 <= all (Select x2 from anomalia where id=new.id) then
    if new.y4 >= all (Select y1 from anomalia where id=new.id) and new.y4 <= all (Select y2 from anomalia where id=new.id) then
      return null;
    end if;
  end if;
  return new;
end;
$$ language plpgsql;

create trigger zona_sobreposta_trigger
before insert on anomalia_traducao
for each row execute procedure zona_sobreposta();
