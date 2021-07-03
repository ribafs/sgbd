# Resumo

## Instalação no linux

sudo apt install sqlite3

sudo apt install php7.3-pdo-sqlite

## Criar um banco

sqlite3 db_agenda

## Criar tabela contatos
create table contatos(id integer primary key AUTOINCREMENT, nome varchar(45));

## mostrar esquema da tabela
.schema contatos

## Listar tabelas do banco atual
.tables

## Sair do terminal
.quit

## Ativar timer
.timer on

.timer off - desativar

## Abrir banco
sqlite3 db_agenda

## Listar bancos
.databases

## Mostrar saída como planilha
.excel

## Help
.help

## Convenção

nomes de bancos do sqlite terminar com .md

https://github.com/lerocha/chinook-database

