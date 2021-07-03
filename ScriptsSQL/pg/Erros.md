# Erros na criação de bancos de dados

## Ao tentar criar uma tabela com relacionamento
```sql
CREATE TABLE clientes (
    id int primary key auto_increment,
    nome varchar(50) not null,
    email varchar(50),
    nascimento date,
    vendedor_id int not null,
    CONSTRAINT `clientes_fk` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedores` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
Apresentava este erro
Erro na consulta (1005): Can't create table `testes`.`clientes` (errno: 150 "Foreign key constraint is incorrectly formed")

Resolvi alterando o esquema da tabela clientes para este:
```sql
CREATE TABLE clientes (
    id int primary key auto_increment,
    nome varchar(50) not null,
    email varchar(50),
    nascimento date,
    vendedor_id int(11) not null,
    KEY `vendedor_fk` (`vendedor_id`),
    CONSTRAINT `clientes_fk` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedores` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
Mas somente funcionou quando antes eu importei para o mesmo banco a tabela vendedores com seus registros.

Efetuei diversas pesquisas sem encontra a solução, mas quando eu importei as duas tabelas removendo antes a foreign key, clientes e vendedores
Depois de importar pelo adminer.org então eu impus a foreign key e exportei o script.
Então fui seguindo os passos para que meu script ficasse semelhante ao dele até chegar a este que funcionou.


