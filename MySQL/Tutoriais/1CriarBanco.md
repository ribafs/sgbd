# Criando um banco de dados

Irei abordar usando comandos do SQL, pois criar gráficamente apenas clicando em botões não tem muito o que ensinar, é bem intuitivo.

Criar um banco usando a console SQL do gerenciador de banco de dados ou mesmo o seu terminal/console

Convencionou-se escrever o nome dos comandos SQL em maiúsculas, mas podemos escrever sem atentar para o case.


Considerando que você está em um geranciador de bancos de dados como o phpMyAdmin, o adminer ou o MySQL Workbench, apenas acesse a aba SQL

## Criar um banco de dados

Forma simplificada

CREATE DATABASE nome;

Sintaxe completa:

CREATE DATABASE [IF NOT EXISTS] nome
[CHARACTER SET charset_name]
[COLLATE collation_name];


## Remover um banco existente

Forma simplificada

DROP DATABASE nome;

Sintaxe completa:

DROP DATABASE [IF EXISTS] nome;


Se estuver usando a console ou terminal do SGBD, no caso o MySQL ou seu fork MariaDb

Caso use no desktop sem senha

mysql -uroot

Se tiver senha

mysql -uroot -p

Agora poderá executar os mesmos comandos acima para criar ou remover o banco.


