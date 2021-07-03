# Dicas de SQL para o MySQL

## DDL - Data Definition Language

Os comandos abaixo podem ser executados no seu gerenciador do MySQL: phpmyadmin, adminer ou outro

Crie um banco de dados

create database cadastro;

create table clientes(
  id int primary key auto_increment,
  nome varchar(50) not null,
  genero ENUM ('M','F')  NOT NULL
);

Importe os dois scripts produtos.sql e pedidos.sql para o banco cadastro.

## SELECT

## Selecionar todos os produtos

select * from produtos;

## Selecionar todos os produtos mas trazendo apenas seus nomes

select nome from produtos;

## Selecionar todos os dados/campos de um produto e chamado 'Mamão'

select * from produtos where nome = 'Mamão';

## Contar quantos registros exietem na tabela produtos

select count(*) from produtos;

## Subconsulta
```sql
SELECT id, nome, quantidade
FROM produtos WHERE quantidade > (SELECT AVG(quantidade) FROM produtos);
```
```sql
SELECT 
    nome, 
    quantidade
FROM
    produtos
WHERE
    quantidade = (SELECT MAX(quantidade) FROM produtos);
```
```sql
INSERT INTO produtos (nome, quantidade)
(  SELECT
    1 AS nome,
    2 AS quantidade
  FROM produtos 
  WHERE quantidade = 100
);
```
## INSERT

Quando temos a chave primária/id do tipo auto_increment, no insert não há necessidade de incluir o id no insert, pois será incluido automaticamente

## Incluir um registro na tabela produtos:

insert into produtos (nome, quantidade) values ('groselha', 40);

## Atualizar um registro específico

update produtos set nome='Laranja pera' where id = 100;

select * from produtos where id=100;

## Obs
Sempre use where em update e em delete, caso contrário a operação acontecerá em todos os registros. Exemplo:

delete from produtos; -- apagará todos os registros da tabela produtos

## Excluir um certo registro de produtos

delete from produtos where id=100;

## DML - Data Manipulation Language

## Adicionar um campo para a tabela produtos

alter table produtos add column teste int;

## Remover um campo da tabela produtos

alter table produtos drop column teste;

## Alterar o engine da tabela produtos para innodb

ALTER TABLE produtos ENGINE = InnoDB;

## Resetar o valor inicial do id

ALTER TABLE produtos AUTO_INCREMENT = 13;

## Alterar o charset da tabela produtos

ALTER TABLE produtos CHARACTER SET = utf8;

## Mudar o tipo do campo

ALTER TABLE produtos MODIFY quantidade BIGINT NOT NULL;

## Renomear um campo

ALTER TABLE produtos change quantidade quant int;

## Remover chave estrangeira

ALTER TABLE produtos DROP FOREIGN KEY fk_nome;


