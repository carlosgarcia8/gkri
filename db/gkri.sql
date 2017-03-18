-- drop table if exists usuarios cascade;
-- create table usuarios (
--     id       bigserial    constraint pk_usuarios primary key,
--     nick     varchar(100) not null constraint uq_usuarios_nick unique,
--     password char(60)     not null,
--     auth_key char(32)     not null,
--     activo   bool         not null default true
-- );

drop table if exists posts cascade;
create table posts (
    id                  bigserial    constraint pk_posts primary key,
    titulo              varchar(100) not null,
    usuario_id          bigint       constraint fk_posts_usuarios_creador
        references public.user(id)
        on delete set null on update cascade,
    fecha_publicacion   timestamp with time zone not null default current_timestamp,
    longpost            bool         not null default false,
    status_id           smallint,
    moderated_by        bigint       not null constraint fk_posts_usuarios_moderador
        references public.user(id)
        on delete no action on update cascade
);

drop table if exists session cascade;
create table session (
    id char(40) not null constraint pk_session primary key,
    expire integer,
    data bytea
);

-- drop table if exists comentarios cascade;
-- create table comentarios (
--     id          bigserial     constraint pk_comentarios primary key,
--     cuerpo      varchar(1000) not null,
--     votos       bigint        not null default 0,
--     usuario_id  bigint        constraint fk_comentarios_usuarios references usuarios(id)
--         on delete set null on update cascade,
--     post_id     bigint        constraint fk_comentarios_posts references posts(id)
--         on delete cascade on update cascade
-- );

drop table if exists upvotes cascade;
create table upvotes (
    usuario_id  bigint        constraint fk_upvotes_usuarios references public.user(id)
        on delete cascade on update cascade,
    post_id     bigint        constraint fk_upvotes_posts references posts(id)
        on delete cascade on update cascade,
    constraint pk_upvotes primary key (usuario_id, post_id)
);

drop table if exists downvotes cascade;
create table downvotes (
    usuario_id  bigint        constraint fk_downvotes_usuarios references public.user(id)
        on delete cascade on update cascade,
    post_id     bigint        constraint fk_downvotes_posts references posts(id)
        on delete cascade on update cascade,
    constraint pk_downvotes primary key (usuario_id, post_id)
);
