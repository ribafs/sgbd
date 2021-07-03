Banco

Duas tabelas relacionadas

Usando phpLiteAdmin e console

create database albuns

CREATE TABLE [albuns]
(
    [id] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    [title] NVARCHAR(160)  NOT NULL,
    [artista_id] INTEGER  NOT NULL,
    FOREIGN KEY ([artist_id]) REFERENCES [artistas] ([id]) 
		ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE [artistas]
(
    [id] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    [name] NVARCHAR(120)
);

CREATE TABLE suppliers (
    id   INTEGER PRIMARY KEY,
    name TEXT    NOT NULL,
    group_id      INTEGER,
    FOREIGN KEY (group_id)
    REFERENCES groups (id) 
       ON UPDATE RESTRICT
       ON DELETE RESTRICT
);

CREATE TABLE groups (
    id   INTEGER PRIMARY KEY,
    name text
);

