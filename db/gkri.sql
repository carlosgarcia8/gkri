-- drop table if exists usuarios cascade;
-- create table usuarios (
--     id       bigserial    constraint pk_usuarios primary key,
--     nick     varchar(100) not null constraint uq_usuarios_nick unique,
--     password char(60)     not null,
--     auth_key char(32)     not null,
--     activo   bool         not null default true
-- );

drop table if exists categorias cascade;

create table categorias (
    id       bigserial   constraint pk_categorias primary key,
    nombre   varchar(20) not null,
    nombre_c varchar(20) not null
);

insert into categorias (nombre, nombre_c)
values ('Gracioso', 'gracioso'), ('Cultura', 'cultura'), ('Amor', 'amor'),
    ('Chicas', 'chicas'), ('Politica', 'politica'), ('GIF', 'gif'),
    ('Estudios', 'estudios'), ('Películas', 'peliculas'), ('Series', 'series'),
    ('WTF', 'wtf'), ('Gamers', 'gamers'), ('Anime/Manga', 'anime-manga'),
    ('Humor Negro', 'humor-negro'), ('Animales', 'animales'), ('Otro', 'otro');

-- alter table profile add column gender char(1);

drop table if exists posts cascade;
create table posts (
    id                  bigserial    constraint pk_posts primary key,
    titulo              varchar(100) not null,
    usuario_id          bigint       constraint fk_posts_usuarios_creador
        references public.user(id)
        on delete set null on update cascade,
    fecha_publicacion   timestamp with time zone not null default current_timestamp,
    fecha_confirmacion  timestamp with time zone,
    extension           varchar(20)    not null,
    categoria_id        bigint         not null constraint fk_posts_categorias
        references categorias(id)
        on delete no action on update cascade,
    status_id           smallint,
    moderated_by        bigint       constraint fk_posts_usuarios_moderador
        references public.user(id)
        on delete no action on update cascade
);

drop table if exists session cascade;
create table session (
    id char(40) not null constraint pk_session primary key,
    expire integer,
    data bytea
);


drop table if exists votos cascade;
create table votos (
    usuario_id  bigint        constraint fk_votos_usuarios references public.user(id)
        on delete cascade on update cascade,
    post_id     bigint        constraint fk_votos_posts references posts(id)
        on delete cascade on update cascade,
    positivo    boolean       not null default true,
    created_at  timestamp with time zone not null default current_timestamp,
    constraint pk_votos primary key (usuario_id, post_id)
);

drop table if exists votos_c cascade;
create table votos_c (
    usuario_id    bigint        constraint fk_votos_c_usuarios references public.user(id)
        on delete cascade on update cascade,
    comentario_id bigint        constraint fk_votos_c_posts references public.comment(id)
        on delete cascade on update cascade,
    positivo      boolean       not null default true,
    constraint pk_votos_c primary key (usuario_id, comentario_id)
);

drop table if exists notificaciones cascade;
create table notificaciones (
    id         bigserial                constraint pk_notificaciones primary key,
    type       smallint                 not null,
    user_id    bigint                   constraint fk_notificaciones_usuarios references public.user(id)
        on delete cascade on update cascade,
    seen       boolean                  not null default false,
    created_at timestamp with time zone not null default current_timestamp,
    post_id    bigint                   constraint fk_notificaciones_posts references posts(id)
        on delete cascade on update cascade
);

drop view if exists v_comment_votos;
create view v_comment_votos
as
select * from comment c left join (select id as id_c, sum(case when positivo=true then 1 when positivo=false then -1 else 0 end) as votos
from votos_c right join comment on votos_c.comentario_id = comment.id
group by id) as v on c.id=v.id_c and "parentId" is null
order by "parentId", votos desc nulls last, "createdAt";

-- select * from comment where "createdBy"=1 and ("entityId","createdAt") in
-- (select "entityId", max("createdAt") from comment where "createdBy"=1 group by "createdBy","entityId") order by "createdAt" desc;
