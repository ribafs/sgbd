# MySQL com utf8

CREATE DATABASE `banco` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```php
Poderá criar uma tabela em UTF-8

CREATE TABLE document (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    campo VARCHAR(50),
) CHARACTER SET utf8 COLLATE utf8_general_ci;
```
Lembre-se de definir o charset UTF-8 em suas páginas HTML
```php
<head>
  <meta charset="UTF-8">
</head>
```
E de utilizar o header UTF-8 nos arquivos PHP
```php
<?php header("Content-type: text/html; charset=utf-8"); ?>
```
Se ainda não for possível cadastrar acentos no banco de dados você poderá utilizar no PHP
```php
// Para mysqli
 mysqli_set_charset($con,"utf8");

// Para PDO
 $dsn = "mysql:host=localhost;dbname=world;charset=utf8";
 $opcoes = array(
     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
 );
 $pdo = new PDO($dsn, $usuario, $senha, $opcoes);
```
## Outra coisa que talvez possa ajudar é adicionando a seu .htaccess
```php
AddDefaultCharset utf-8
```php
Lembre-se, "nenhum UTF-8 é de mais".
----------
Resolvendo problemas de caracteres acentuados no MySQL

Antes de importar os dados para a sua base MySQL, defina um collation padrão. No Brasil o Latin1 é o mais utilizado, então o CHARSET (codificação de caracteres) padrão na Maxrevenda é o Latin1 e o COLLATE (collation) padrão é o latin1_general_ci. Scripts externos podem utilizar UTF8 e geralmente é por causa da diferença de codificação entre Latin1 e UTF8 que ocorrem erros de acentuação.
A seguir estão alguns exemplos para definir um collation padrão para a sua base de dados:
```php
ALTER DATABASE `sua_base` CHARSET = Latin1 COLLATE = latin1_swedish_ci;

ou

 ALTER DATABASE `sua_base` CHARSET = UTF8 COLLATE = utf8_general_ci;
```
CHARSET e COLLATE são coisas distintas, no MySQL, cada CHARSET possui COLLATEs, cada um com sua particularidade. O intuito deste Wiki não é explicar as características de cada um deles, pois pode ser visto da documentação do MySQL, mas daremos um pequeno descritivo entre latin1_general_ci, latin1_general_cs e latin1_swedish_ci.

    latin1_general_ci: Não há distinção entre letras maiúsculas e minúsculas. Buscando por “teste”, registros como “Teste” ou “TESTE” serão retornados.

    latin1_general_cs: Distingue letras maiúsculas e minúsculas. Buscando por “teste” somente retornará “teste”. Opções como “Teste” e “TESTE” não serão retornadas.

    latin1_swedish_ci: Não distingue letras minúsculas e maiúsculas e nem caracteres acentuados e com cedilha, ou seja, o registro que contém a palavra “Intuição” será retornado quando houver uma procura pela palavra “intúicao”.

Quando você estiver exportando os dados da sua base de dados de origem, certifique-se de estar especificando a codificação corretamente. No phpMyAdmin há um menu DropDown próximo às opções de compactação ‘nenhum’, ‘zip’, ‘gzip’ e ‘bzip’ que normalmente está selecionada a opção ‘utf-8’. Mantenha este se sua base estiver com este CHARSET, do contrário, especifique ‘iso-8859-1’ caso ela esteja com o CHARSET Latin1.Faça o mesmo durante a importação. Ao enviar o arquivo, o menu DropDown estará como ‘utf-8’, se o CHARSET da base for ‘Latin1’ escolha o ‘iso-8859-1’.
---------------
## Configurando charset de uma aplicação PHP

Imagine que você está desenvolvendo uma aplicação para Internet em seu ambiente local, e chegou o dia de colocar o sistema em produção, um servidor compartilhado, hospedagem. Além de verificar se está tudo de acordo com as funcionalidades, uma das preocupações nesse cenário é analisar se o charset está devidamente configurado na aplicação e no banco de dados.
O que é charset?

Charset, Character Set, é o conjunto de caracteres que são utilizados para criação de documentos, bancos de dados, sites etc. Cada charset possui uma lista de caracteres disponíveis, sendo estes representados por uma posição de referência.

Confira alguns caracteres disponíveis no charset ASCII.
```php
Posição 	Caractere
65 	A
66 	B
67 	C
68 	D
69 	E
70 	F
```
Qual é a importância do charset?

O charset de um documento indica ao browser qual codificação foi utilizada, possibilitando que o documento seja interpretado, exibindo suas informações corretamente ao usuário. Caso exista algum tipo de incompatibilidade entre o conteúdo, o charset declarado e o charset utilizado para salvar o documento no seu editor – como Eclipse -, isso poderá comprometer sua exibição, gerando possíveis problemas, como erro na codificação do documento ou caracteres incorretos sendo exibidos na aplicação.
Configurando charset de uma aplicação PHP

Existem 127 charsets disponíveis para uso na Internet, e os mais utilizados são ISO-8859-1 e UTF-8. Se você está desenvolvendo algum conteúdo, terá que decidir qual codificação irá utilizar. O charset UTF-8 é uma recomendação, pois cobre quase todos os caracteres e símbolos do mundo.

Confira os passos recomendados para configurar o charset de sua aplicação.

Recomendações para configurar o navegador

## Script PHP

Informar o charset na declaração dos formulários, caso exista.Informar o charset no início do script, junto ao tipo do conteúdo, nesse caso html.
```php
<?php header("Content-type: text/html; charset=utf-8"); ?>
```
Metatag HTML

Informar o charset através da metatag no cabeçalho do código html.
```php
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
```
Formulário
```php
<form accept-charset="utf-8" ...>
```
## Recomendações para configurar o banco de dados

Verificar se as tabelas e os campos de caracteres estão configurados para utilizar coleção utf8_general_ci, além de informar o charset ao abrir conexão com banco de dados.

## Conexão MySQL
```php
mysql_set_charset('utf8');
```
Conexão PDO
```php
$handle = new PDO("mysql:host=localhost;dbname=dbname",
    'username', 'password',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
```
Conexão ZF2
```php
return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=dbname;host=localhost',
        'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"),
    ),
);
```
Informar o charset através da função mysql_set_charset.
	
mysql_set_charset('utf8');

## Conclusão

Espero que vocês economizem um pouco do tempo que passei ao pesquisar esse tema. Apesar de o artigo ter foco em uma aplicação PHP, os passos são semelhantes em outros cenários. Confira também o artigo de Rob Allen, sobre UTF-8, PHP e MySQL, pois contém dicas valiosas.
Antes de implantar sua aplicação, teste separadamente no servidor de produção.

Referência(s)

    http://akrabat.com/php/utf8-php-and-mysql/ UTF-8, PHP and MySQL. Allen, Rob. Acesso em: 20 fevereiro 2015.
    http://www.w3.org/International/getting-started/ characters Charsets. W3. Acesso em 21 fevereiro 2015.

