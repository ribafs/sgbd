## 3.6 - Dicas de SQL para o MySQL

### DDL - Data Definition Language

Os comandos abaixo podem ser executados no seu gerenciador do MySQL: phpmyadmin, adminer ou outro

### Crie um banco de dados e uma tabela
```sql
mysql -u root

create database cadastro;

create table clientes(
  id int primary key auto_increment,
  nome varchar(50) not null,
  genero ENUM ('M','F')  NOT NULL
);
\q
```

### SELECT

### Selecionar todos os produtos
```sql
select * from produtos;
```
### Selecionar todos os produtos mas trazendo apenas seus nomes
```sql
select nome from produtos;
```
### Selecionar todos os dados/campos de um produto e chamado 'Mamão'
```sql
select * from produtos where nome = 'Mamão';
```
### Contar quantos registros exietem na tabela produtos
```sql
select count(*) from produtos;
```
### Subconsulta
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
### INSERT

Quando temos a chave primária/id do tipo auto_increment, no insert não há necessidade de incluir o id no insert, pois será incluido automaticamente

### Incluir um registro na tabela produtos:
```sql
insert into produtos (nome, quantidade) values ('groselha', 40);
```
### Atualizar um registro específico
```sql
update produtos set nome='Laranja pera' where id = 100;

select * from produtos where id=100;
```
### Obs
Sempre use where em update e em delete, caso contrário a operação acontecerá em todos os registros. Exemplo:
```sql
delete from produtos; -- apagará todos os registros da tabela produtos
```
### Excluir um certo registro de produtos
```sql
delete from produtos where id=100;
```
### DML - Data Manipulation Language

### Adicionar um campo para a tabela produtos
```sql
alter table produtos add column teste int;
```
### Remover um campo da tabela produtos
```sql
alter table produtos drop column teste;
```
### Alterar o engine da tabela produtos para innodb
```sql
ALTER TABLE produtos ENGINE = InnoDB;
```
### Resetar o valor inicial do id
```sql
ALTER TABLE produtos AUTO_INCREMENT = 13;
```
### Alterar o charset da tabela produtos
```sql
ALTER TABLE produtos CHARACTER SET = utf8;
```
### Mudar o tipo do campo
```sql
ALTER TABLE produtos MODIFY quantidade BIGINT NOT NULL;
```
### Renomear um campo
```sql
ALTER TABLE produtos change quantidade quant int;
```
### Remover chave estrangeira
```sql
ALTER TABLE produtos DROP FOREIGN KEY fk_nome;
```

### Referência sobre SQL

https://www.w3schools.com/sql/default.asp



