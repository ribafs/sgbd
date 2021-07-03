# Usando bancos de dados para a web, com o PHP

Em geral nós programadores nos concentramos basicamente no código e o banco é apenas algo para guardar as informações. Este comportamenteo gera vários problemas.

Veja esta informação: eu andei mexendo em vários frameworks PHP. CakePHP, Laravel, FuelPHP, Yii e outros. Vários destes tem uma ferramenta para gerar CRUDs, tipo scaffold.
Mas sabe quais destes gera os CRUDs com suporte ao relacionamento nas tabelas? Somente o CakePHP.

## Relacionamento entre duas tabelas de um para vários
Supondo um banco com as tabelas produtos e pedidos relacionadas, fazendo com que pedidos tenha um campo produto_id, mas não somente, impondo restrições no banco assim:
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

## Dica
Sempre que for importar um script para o banco com duas tabelas relacionadas, importe primeiro a tabela primária (aquela que não tem a foreign key) e depois importe a que tem a foreign key.

## Importãncia do relacionamento
No nosso exemplo a restrição imposta impedirá que cadastremos um pedido para um produto que não esteja cadastrado.
Uma boa medida é criar uma combo no formulário de add.php para produto_id que seja populada com todos os IDs de produtos. 
Assim o usuário não terá a possibilidade de errar o ID do produto, apenas escolherá.

Outra característica do nosso relacionamento é que o usuário quando excluir um pedido o respectivo produto não será removido.
Mas quando atualizar um pedido o produto será automaticamente atualizado. Isso devido a estes comandos:

.. ON DELETE RESTRICT ON UPDATE CASCADE

## Restrições em Geral

Não somente o relacionamento/foreign key é importante mas muitas outras constraints/restrições:

- primary key - este garante que o valor do campo seja exclusivo em todos os registros e não nulo. Só é permitido existir uma primary key por tabela
- foreign key - garante a integridade das informações entre tabelas
- tipo de dados. Exemplo: se criei um campo com int eé não aceitará string, evitando erros. Temos tipos int, decimal(), text, etc
- tamanho do campo - varchar(50). Limita em até 50 caracteres a entrada de dados
- NOT NULL - esta constraint não aceitará que o campo não seja preenchido
- UNIQUE() - Esta exige que cada registro tenha um valor exclusivo neste campo. Bom para campos de username. É permitido ter mais de um por tabela
- check(preco > 0) - Efetua uma verificação no valor do campo sempre antes de inserir

Existem várias outras e isso também depende do SGBD.

## Planejamento
Sempre antes de iniciar a criação de um banco de dados, sente, pegue um papel e caneta ou crie um arquivo texto no computador onde deve anotar informações sobre o banco de dados a ser criado:
- Tabelas, quantidade e nomes
- Chaves primárias.  Geralmente se usa ID como chave, mas se puder use algo mais significativo como cpf, matricula, etc
- Relacionamento entra as tabelas e por qual campo/foreign key
- Campos de cada tabela: nomes, tipos de dados e tamanhos
- Constraints de cada campo
Este planejamento deve ser mais elaborado caso o projeto seja importante

## Criação de bancos restringindo privilégios
Idealmente devemos sempre criar um usuário para cada site ou aplicativo. Assim podemos controlar os privilégios desse usuário, assim reforçando a segurança.

Em geral quando se instala o CMS Joomla se garante todos os privilégios do MySQL para este usuário, mas recomenda-se restringir e conceder somente os necessários. Veja um exemplo que costumo usar:

create database portal;
CREATE USER 'portal'@'localhost' IDENTIFIED BY 'senha';
GRANT ALTER CREATE CREATE TEMPORARY TABLES DELETE DROP INDEX INSERT LOCK TABLES SELECT UPDATE ON portal.* TO user_portal@localhost IDENTIFIED BY 'senhaforte' WITH GRANT OPTION; 

## Melhorando a segurança do MySQL
Se você tiver acesso e puder executar use para melhorar a segurança:

sudo mysql_secure_installation

- Use uma senha forte para o root do MySQL
- Não deixe o root ser acessado remotamente, 
- Remova usuários anônimos
- Remova o banco test

## Aprimorar e Caprichar sempre
Como acredito que é importante para nós realizarmos algo bem feito e nos valoriza frente ao mercado de trabalho, então que estas dicas ajudem você a criar um banco melhor para seus aplicativos e torne isso uma atitude.

Boa codificação!
