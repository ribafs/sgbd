# Relacionamento 1 para Vários entre duas tabelas

Importante que para ser rigoroso em um banco de dados do tipo relacional todas as tabelas deveriam ser idealmente relacionadas. Isso geralmente não acontece mas é bom ficar atento para as vantagens do relacionamento. Empresas, clientes, vendedores, produtos, pedidos. É importane relacionar tudo.

Relacionamentos são comandos inseridos em tabelas para garantir a integridade dos registros.

- Em tabelas relacionadas não podemos inserir registros na tabela relacionada/secundária sem ter o respectivo registro na tabela primária. Exemplo:
Não podemos inserir um pedido sem antes cadastrar os dados do cliente.

## Tipos de relacionamentos

Relacionamentos entre tabelas

1 - 1
1 - N (vários)
N (vários) - N (vários)

O último (N para N) precisa ser dividido em dois, assim:

N -> 1 e 1 <-N

Ou seja, recisa nascer uma terceira tabela.

## Exemplos

### 1 para 1

filhos para pais (a cada filho corresponde um pai)

### N para N

produtos e pedidos

Precisa nascer

produtos N - 1 itens_pedidos 1 - N pedidos

Como cada pedido tem vários produtos, criamos itens de pedido que lista os pedidos do pedido e cada item da lista se liga a cada produto

### 1 para N

Este é o tipo mais comum e o que detalharemos

## Tabelas

- Primária - onde fica um campo chave primária (primary key), onde cada registro é cadastrado somente uma vez, sem dupliciação. Ex.: clientes
- Secundária - onde fica o campo cheve estrangeira (foreign key), onde os registros podem ser duplicados. Ex.: pedidos
- O campo foreign key precisa ser do mesmom tipo e tamanho e precisa ser NOT NULL

## Exemplo simplificado: produtos e pedidos
```sql
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
    CONSTRAINT `fk-produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
);
```

Também podemos ter uma tabela se relacionando com duas ou mais outras tabelas.

## Inserindo dados nas tabelas

insert into produtos ...

insert into pedidos ... (join)

Veja que em pedidos temos um campo que vinculará as duas tabelas (chave estrangeira), que é produto_id e também temos o código da foreign key:
    CONSTRAINT `fk-produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE

## Benefícios e consequências do relacionamento

- Precisamos primeiro cadastrar os registros da tabela primária, produtos, para somente depois cadastrar os da tabela secundária, pedidos.
- Não podemos cadastrar um pedido sem ter cadastrado o respectivo produto
- Inclusive esta sequência deve ser respeitada ao importar scripts sql: produtos e deus registros devem ser importados antes de pedidos
- 


## Detalhes sobre as opções do foreign key

[CONSTRAINT nome_chave_estrangeira] FOREIGN KEY (nomes de colunas separados por vírgulas)
REFERENCES nome_tabela_pai (nomes de colunas separados por vírgulas na tabela pai)
[ON DELETE ação referencial]
[ON UPDATE ação referencial];

    CASCADE: A opção CASCADE permite excluir ou atualizar os registros relacionados presentes na tabela filha automaticamente, quando um registro da tabela pai for atualizado (ON UPDATE) ou excluído (ON DELETE). É a opção mais comum aplicada.

    RESTRICT: Impede que ocorra a exclusão ou a atualização de um registro da tabela pai, "caso ainda hajam registros na tabela filha". Uma exceção de violação de chave estrangeira é retornada. A verificação de integridade referencial é realizada antes de tentar executar a instrução UPDATE ou DELETE

    SET NULL: Esta opção é usada para definir com o valor NULL o campo na tabela filha quando um registro da tabela pai for atualizado ou excluído.

    NO ACTION: Essa opção equivale à opção RESTRICT, porém a verificação de integridade referencial é executada após a tentativa de alterar a tabela. É a opção padrão, aplicada caso nenhuma das opções seja definida na criação da chave estrangeira.

    SET DEFAULT: “Configura Padrão” – Define um valor padrão na coluna na tabela filha, aplicado quando um registro da tabela pai for atualizado ou excluído.

mais informações: https://dev.mysql.com/doc/refman/5.7/en/create-table-foreign-keys.html

