--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.6
-- Dumped by pg_dump version 9.5.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: comment; Type: TABLE; Schema: public; Owner: gkri
--

drop table if exists votos cascade;
drop table if exists posts cascade;
drop table if exists session cascade;
drop table if exists votos_c cascade;
drop table if exists categorias cascade;
drop table if exists public.user cascade;
drop table if exists public.comment cascade;
drop table if exists public.token cascade;
drop table if exists public.social_account cascade;
drop table if exists public.profile cascade;
drop table if exists public.migration cascade;
drop view if exists v_comment_votos;


CREATE TABLE comment (
    id integer NOT NULL,
    entity character(10) NOT NULL,
    "entityId" integer NOT NULL,
    content text NOT NULL,
    "parentId" integer,
    level smallint DEFAULT 1 NOT NULL,
    "createdBy" integer NOT NULL,
    "updatedBy" integer NOT NULL,
    status smallint DEFAULT 1 NOT NULL,
    "createdAt" integer NOT NULL,
    "updatedAt" integer NOT NULL,
    "relatedTo" character varying(500) NOT NULL,
    url text
);


ALTER TABLE comment OWNER TO gkri;

--
-- Name: Comment_id_seq; Type: SEQUENCE; Schema: public; Owner: gkri
--

CREATE SEQUENCE "Comment_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Comment_id_seq" OWNER TO gkri;

--
-- Name: Comment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gkri
--

ALTER SEQUENCE "Comment_id_seq" OWNED BY comment.id;


--
-- Name: social_account; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE social_account (
    id integer NOT NULL,
    user_id integer,
    provider character varying(255) NOT NULL,
    client_id character varying(255) NOT NULL,
    data text,
    code character varying(32) DEFAULT NULL::character varying,
    created_at integer,
    email character varying(255) DEFAULT NULL::character varying,
    username character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE social_account OWNER TO gkri;

--
-- Name: account_id_seq; Type: SEQUENCE; Schema: public; Owner: gkri
--

CREATE SEQUENCE account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE account_id_seq OWNER TO gkri;

--
-- Name: account_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gkri
--

ALTER SEQUENCE account_id_seq OWNED BY social_account.id;


--
-- Name: categorias; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE categorias (
    id bigint NOT NULL,
    nombre character varying(20) NOT NULL,
    nombre_c character varying(20) NOT NULL
);


ALTER TABLE categorias OWNER TO gkri;

--
-- Name: categorias_id_seq; Type: SEQUENCE; Schema: public; Owner: gkri
--

CREATE SEQUENCE categorias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE categorias_id_seq OWNER TO gkri;

--
-- Name: categorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gkri
--

ALTER SEQUENCE categorias_id_seq OWNED BY categorias.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE migration OWNER TO gkri;

--
-- Name: posts; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE posts (
    id bigint NOT NULL,
    titulo character varying(100) NOT NULL,
    usuario_id bigint,
    fecha_publicacion timestamp with time zone DEFAULT now() NOT NULL,
    fecha_confirmacion timestamp with time zone,
    extension character varying(20) NOT NULL,
    categoria_id bigint NOT NULL,
    status_id smallint,
    moderated_by bigint
);


ALTER TABLE posts OWNER TO gkri;

--
-- Name: posts_id_seq; Type: SEQUENCE; Schema: public; Owner: gkri
--

CREATE SEQUENCE posts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE posts_id_seq OWNER TO gkri;

--
-- Name: posts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gkri
--

ALTER SEQUENCE posts_id_seq OWNED BY posts.id;


--
-- Name: profile; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE profile (
    user_id integer NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    public_email character varying(255) DEFAULT NULL::character varying,
    gravatar_email character varying(255) DEFAULT NULL::character varying,
    gravatar_id character varying(32) DEFAULT NULL::character varying,
    location character varying(255) DEFAULT NULL::character varying,
    website character varying(255) DEFAULT NULL::character varying,
    bio text,
    timezone character varying(40) DEFAULT NULL::character varying,
    gender character(1)
);


ALTER TABLE profile OWNER TO gkri;

--
-- Name: session; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE session (
    id character(40) NOT NULL,
    expire integer,
    data bytea
);


ALTER TABLE session OWNER TO gkri;

--
-- Name: token; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE token (
    user_id integer NOT NULL,
    code character varying(32) NOT NULL,
    created_at integer NOT NULL,
    type smallint NOT NULL
);


ALTER TABLE token OWNER TO gkri;

--
-- Name: user; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE "user" (
    id integer NOT NULL,
    username character varying(25) NOT NULL,
    email character varying(255) NOT NULL,
    password_hash character varying(60) NOT NULL,
    auth_key character varying(32) NOT NULL,
    confirmed_at integer,
    unconfirmed_email character varying(255) DEFAULT NULL::character varying,
    blocked_at integer,
    registration_ip character varying(45),
    created_at integer NOT NULL,
    updated_at integer NOT NULL,
    flags integer DEFAULT 0 NOT NULL,
    last_login_at integer
);


ALTER TABLE "user" OWNER TO gkri;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: gkri
--

CREATE SEQUENCE user_id_seq
    START WITH 2
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO gkri;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gkri
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: votos_c; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE votos_c (
    usuario_id bigint NOT NULL,
    comentario_id bigint NOT NULL,
    positivo boolean DEFAULT true NOT NULL
);


ALTER TABLE votos_c OWNER TO gkri;

--
-- Name: v_comment_votos; Type: VIEW; Schema: public; Owner: gkri
--

CREATE VIEW v_comment_votos AS
 SELECT c.id,
    c.entity,
    c."entityId",
    c.content,
    c."parentId",
    c.level,
    c."createdBy",
    c."updatedBy",
    c.status,
    c."createdAt",
    c."updatedAt",
    c."relatedTo",
    c.url,
    v.id_c,
    v.votos
   FROM (comment c
     LEFT JOIN ( SELECT comment.id AS id_c,
            sum(
                CASE
                    WHEN (votos_c.positivo = true) THEN 1
                    WHEN (votos_c.positivo = false) THEN '-1'::integer
                    ELSE 0
                END) AS votos
           FROM (votos_c
             RIGHT JOIN comment ON ((votos_c.comentario_id = comment.id)))
          GROUP BY comment.id) v ON (((c.id = v.id_c) AND (c."parentId" IS NULL))))
  ORDER BY c."parentId", v.votos DESC NULLS LAST, c."createdAt";


ALTER TABLE v_comment_votos OWNER TO gkri;

--
-- Name: votos; Type: TABLE; Schema: public; Owner: gkri
--

CREATE TABLE votos (
    usuario_id bigint NOT NULL,
    post_id bigint NOT NULL,
    positivo boolean DEFAULT true NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE votos OWNER TO gkri;

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY categorias ALTER COLUMN id SET DEFAULT nextval('categorias_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY comment ALTER COLUMN id SET DEFAULT nextval('"Comment_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY posts ALTER COLUMN id SET DEFAULT nextval('posts_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY social_account ALTER COLUMN id SET DEFAULT nextval('account_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Name: Comment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gkri
--

SELECT pg_catalog.setval('"Comment_id_seq"', 4, true);


--
-- Name: account_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gkri
--

SELECT pg_catalog.setval('account_id_seq', 1, false);


--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY categorias (id, nombre, nombre_c) FROM stdin;
1	Gracioso	gracioso
2	Cultura	cultura
3	Amor	amor
4	Chicas	chicas
5	Politica	politica
6	GIF	gif
7	Estudios	estudios
8	Películas	peliculas
9	Series	series
10	WTF	wtf
11	Gamers	gamers
12	Anime/Manga	anime-manga
13	Humor Negro	humor-negro
14	Animales	animales
15	Otro	otro
\.


--
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gkri
--

SELECT pg_catalog.setval('categorias_id_seq', 15, true);


--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY comment (id, entity, "entityId", content, "parentId", level, "createdBy", "updatedBy", status, "createdAt", "updatedAt", "relatedTo", url) FROM stdin;
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY migration (version, apply_time) FROM stdin;
m000000_000000_base	1493545305
m010101_100001_init_comment	1493545309
m160629_121330_add_relatedTo_column_to_comment	1493545309
m161109_092304_rename_comment_table	1493545309
m161114_094902_add_url_column_to_comment_table	1493545309
m140209_132017_init	1493545310
m140403_174025_create_account_table	1493545310
m140504_113157_update_tables	1493545310
m140504_130429_create_token_table	1493545310
m140830_171933_fix_ip_field	1493545310
m140830_172703_change_account_table_name	1493545310
m141222_110026_update_ip_field	1493545310
m141222_135246_alter_username_length	1493545310
m150614_103145_update_social_account_table	1493545310
m150623_212711_fix_username_notnull	1493545310
m151218_234654_add_timezone_to_profile	1493545310
m160929_103127_add_last_login_at_to_user_table	1493545310
\.


--
-- Data for Name: posts; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY posts (id, titulo, usuario_id, fecha_publicacion, fecha_confirmacion, extension, categoria_id, status_id, moderated_by) FROM stdin;
\.


--
-- Name: posts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gkri
--

SELECT pg_catalog.setval('posts_id_seq', 1, false);


--
-- Data for Name: profile; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY profile (user_id, name, public_email, gravatar_email, gravatar_id, location, website, bio, timezone, gender) FROM stdin;
1	\N	\N	\N	\N	\N	\N	\N	\N	M
\.


--
-- Data for Name: session; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY session (id, expire, data) FROM stdin;
\.


--
-- Data for Name: social_account; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY social_account (id, user_id, provider, client_id, data, code, created_at, email, username) FROM stdin;
\.


--
-- Data for Name: token; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY token (user_id, code, created_at, type) FROM stdin;
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY "user" (id, username, email, password_hash, auth_key, confirmed_at, unconfirmed_email, blocked_at, registration_ip, created_at, updated_at, flags, last_login_at) FROM stdin;
1	xharly8	gjcarlos8@gmail.com	$2y$12$JJhA1ThuSMG5Ul5f4m5JOOMOCdZgT.Ppn2SGAS32yo/Q9KfSoEOni	yBKbCIpQuxZDje0jLni8Xq6s8p777eh6	1493235661	\N	\N	127.0.0.1	1493235633	1493235633	0	1493755572
\.


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gkri
--

SELECT pg_catalog.setval('user_id_seq', 1, false);


--
-- Data for Name: votos; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY votos (usuario_id, post_id, positivo, created_at) FROM stdin;
\.


--
-- Data for Name: votos_c; Type: TABLE DATA; Schema: public; Owner: gkri
--

COPY votos_c (usuario_id, comentario_id, positivo) FROM stdin;
\.


--
-- Name: Comment_pkey; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY comment
    ADD CONSTRAINT "Comment_pkey" PRIMARY KEY (id);


--
-- Name: account_pkey; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY social_account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);


--
-- Name: migration_pkey; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: pk_categorias; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY categorias
    ADD CONSTRAINT pk_categorias PRIMARY KEY (id);


--
-- Name: pk_posts; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY posts
    ADD CONSTRAINT pk_posts PRIMARY KEY (id);


--
-- Name: pk_session; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY session
    ADD CONSTRAINT pk_session PRIMARY KEY (id);


--
-- Name: pk_votos; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT pk_votos PRIMARY KEY (usuario_id, post_id);


--
-- Name: pk_votos_c; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos_c
    ADD CONSTRAINT pk_votos_c PRIMARY KEY (usuario_id, comentario_id);


--
-- Name: profile_pkey; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY profile
    ADD CONSTRAINT profile_pkey PRIMARY KEY (user_id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: account_unique; Type: INDEX; Schema: public; Owner: gkri
--

CREATE UNIQUE INDEX account_unique ON social_account USING btree (provider, client_id);


--
-- Name: account_unique_code; Type: INDEX; Schema: public; Owner: gkri
--

CREATE UNIQUE INDEX account_unique_code ON social_account USING btree (code);


--
-- Name: idx-Comment-entity; Type: INDEX; Schema: public; Owner: gkri
--

CREATE INDEX "idx-Comment-entity" ON comment USING btree (entity);


--
-- Name: idx-Comment-status; Type: INDEX; Schema: public; Owner: gkri
--

CREATE INDEX "idx-Comment-status" ON comment USING btree (status);


--
-- Name: token_unique; Type: INDEX; Schema: public; Owner: gkri
--

CREATE UNIQUE INDEX token_unique ON token USING btree (user_id, code, type);


--
-- Name: user_unique_email; Type: INDEX; Schema: public; Owner: gkri
--

CREATE UNIQUE INDEX user_unique_email ON "user" USING btree (email);


--
-- Name: user_unique_username; Type: INDEX; Schema: public; Owner: gkri
--

CREATE UNIQUE INDEX user_unique_username ON "user" USING btree (username);


--
-- Name: fk_posts_categorias; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY posts
    ADD CONSTRAINT fk_posts_categorias FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON UPDATE CASCADE;


--
-- Name: fk_posts_usuarios_creador; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY posts
    ADD CONSTRAINT fk_posts_usuarios_creador FOREIGN KEY (usuario_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: fk_posts_usuarios_moderador; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY posts
    ADD CONSTRAINT fk_posts_usuarios_moderador FOREIGN KEY (moderated_by) REFERENCES "user"(id) ON UPDATE CASCADE;


--
-- Name: fk_user_account; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY social_account
    ADD CONSTRAINT fk_user_account FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: fk_user_profile; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY profile
    ADD CONSTRAINT fk_user_profile FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: fk_user_token; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY token
    ADD CONSTRAINT fk_user_token FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: fk_votos_c_posts; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos_c
    ADD CONSTRAINT fk_votos_c_posts FOREIGN KEY (comentario_id) REFERENCES comment(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_votos_c_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos_c
    ADD CONSTRAINT fk_votos_c_usuarios FOREIGN KEY (usuario_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_votos_posts; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT fk_votos_posts FOREIGN KEY (post_id) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_votos_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: gkri
--

ALTER TABLE ONLY votos
    ADD CONSTRAINT fk_votos_usuarios FOREIGN KEY (usuario_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--
