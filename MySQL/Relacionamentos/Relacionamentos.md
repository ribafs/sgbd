# Relacionamentos entre tabelas

Tabelas como pedidos e clientes, pedidos e produtos, grupos e usuários e outras similares devem ser relacionadas com a constraint foreign key, para garantir a integridade dos dados.

## Exemplos:

Sem relacionamentos uma tabela de pedidos permite cadastrar um pedido para um cliente que não existe, mas quando bem relacionadas somente cadastrar pedido para cliente já cadastrado. Assim como não permitirá remover um cliente que tenha pedidos em seu nome.

## Foreign key

pedidos e produtos

Dica: Ao importar scripts de tabelas relacionadas sempre importe primeiro a tabela primária, aquela que não tem chave estrangeira, neste caso, produtos

CREATE TABLE produtos (
    id int primary key auto_increment,
    nome varchar(50) not null,
    quantidade int
);

CREATE TABLE pedidos (
    id int primary key auto_increment,
    data date not null,
    quantidade int,
    produto_id int not null,
    CONSTRAINT `fk-produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);


