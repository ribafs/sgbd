# Constraints/Restrições

As cosntraints inpedem que se entre qualquer coisa num registro que pepde varchar(20).

## Tipos de dados

- varchar(n)
- text
- char()
- date
- datetime
- time
- enum('c1','c2')
- int, smallint, tinyint, mediumint, bitint
- numedic, decimal
- Entre outros
https://dev.mysql.com/doc/refman/8.0/en/data-types.html 

## Valor default

valor VARCHAR(10) DEFAULT '5'

Neste caso, quando este registro for cadastrado e não for digitado nada neste campo será adotado o valor 5.
Acho isso uma temeridade e dificilmente tem coerência.
Evite ao máximo usar valor default.

## Algumas Constraints

- primary key - garantir valores exclusivos e não nulos
- foreign key - relacionar duas tabelas
- not null - impedir cadastro com campo vazio
- unique - obrigar campos diferentes
- default - garantir um valor default para o campo
- check - checar valor de campos

Check - 
no_page decimal(5,0) 
CHECK(no_page > 0) ,


