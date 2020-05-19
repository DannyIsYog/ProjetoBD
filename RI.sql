drop trigger if exists email_utilizador_regular_trigger on utilizador_regular;

create or replace function email_utilizador_regular_verifier()
  returns trigger as
$$
begin
  if new.email in (Select email from utilizador_qualificado) then
    raise exception 'Este Utilizador já é um utilizador qualificado.';
  end if

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
  end if

  return new;
end;
$$ language plpgsql;

create trigger email_utilizador_qualificado_trigger
before insert on utilizador_qualificado
for each row execute procedure email_utilizador_qualificado_verifier();
