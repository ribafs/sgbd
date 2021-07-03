# Tabelas

Pessoas

-- Tabelas
create table logradouros
(
	logradouro int primary key,
	descricao varchar(50) not null
);

create table bairros
(
	bairro int primary key,
	descricao varchar(50) not null
);

create table ufs
(
	uf int primary key,
	descricao varchar(2) not null
);

create table municipios
(
	municipio varchar(50) primary key,
	uf int not null,
	constraint uf_fk foreign key (uf) references ufs(uf)
);

create table ceps
(
	cep dom_cep,
	tipo int, 
	logradouro int,
	bairro int,
	municipio int,
	primary key(cep, logradouro), 
	constraint tipo_fk foreign key (tipo) references tipos(tipo),
	constraint logradouro_fk foreign key (logradouro) references logradouros(logradouro),
	constraint bairro_fk foreign key (bairro) references bairros(bairro),
	constraint municipio_fk foreign key (municipio) references municipios(municipio)
);

create table enderecos
(
	cep int not null,
	logradouro int not null,
	numero varchar(8) not null,
	primary key(cep, numero),
	constraint cep_fk foreign key (cep,logradouro) references ceps(cep,logradouro)
);

-- Lembrando que aqui ainda faltam alguns atributos para o endereço: bloco, andar, apartamento e talvez ainda outros

create table telefones
(
	telefone int not null primary key,
	ddd varchar(4) not null,
	numero dom_telefone
);

create table fisicas
(
	fisica int primary key,
	cpf dom_cpf
);

create table juridicas
(
	cnpj dom_cnpj primary key,
	inscricao_estadual dom_ie_ce,
	site dom_url
);

create table pessoas
(
	pessoa int not null primary key,	
	nome varchar(45) not null,
	cep int not null,
	tipo int not null,
	numero varchar(8) null,
	telefone int, -- Permitindo NULL, para o caso de alguém não ter telefone
	email dom_email,
	constraint telefone_fk foreign key (telefone) references telefones(telefone),
	constraint endereco_fk foreign key (cep,numero) references enderecos(cep,numero),
	constraint fisica_fk foreign key(tipo) references fisicas(fisica),
	constraint juridica_fk foreign key(tipo) references juridicas(cnpj)
);

-- Criação de índices parciais, que permitirão a criação de campos com CPF únicos, mas somente para os que existirem

create unique index idx_cpf on fisicas (cpf)
    WHERE NOT (cpf = 'informal');

create unique index idx_ie on juridicas (inscricao_estadual)
    WHERE NOT (inscricao_estadual = 'isento');

-- INSERINDO ALGUNS REGISTROS PARA TESTE

insert into fisicas values(1, '22366437803');
insert into fisicas values(2, '47720595203');
insert into fisicas values(3, '33557245640');
insert into fisicas values(4, '56484636427');
--insert into fisicas values(5, '56484636426'); -- inválido
insert into fisicas values(6, 'informal');
insert into fisicas values(7, '90807363685');
--insert into fisicas values(8, 'informal_erro');
insert into fisicas values(8, 'informal'); -- aceita repetir informal
insert into fisicas values(9, 'informal');
insert into fisicas values(10, 'informal');

CREATE TABLE Telefones
(
    IdTelefone          INT IDENTITY(1,1),
    IdCliente           INT NULL,
    TipoTelefone        VARCHAR(15) NOT NULL,
    NumeroTelefone      VARCHAR(15) NOT NULL
     
    CONSTRAINT PK_Telefone PRIMARY KEY (IdTelefone),
    CONSTRAINT FK_Telefones_IdCliente FOREIGN KEY (IdCliente)
                    REFERENCES Clientes (IdCliente)
)
 
--Insiro alguns registros na tabela Telefones
INSERT INTO Telefones VALUES (1, 'Residencial', '3243-2015')
INSERT INTO Telefones VALUES (3, 'Comercial', '3221-0132')
INSERT INTO Telefones VALUES (1, 'Celular', '9777-2112')
INSERT INTO Telefones VALUES (2, 'Residencial', '3353-9899')
INSERT INTO Telefones VALUES (2, 'Celular', '8871-1015')


CREATE TABLE categories(
    categoryId INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(100) NOT NULL
) ENGINE=INNODB;

CREATE TABLE products(
    productId INT AUTO_INCREMENT PRIMARY KEY,
    productName varchar(100) not null,
    categoryId INT,
    CONSTRAINT fk_category
    FOREIGN KEY (categoryId) 
        REFERENCES categories(categoryId)
) ENGINE=INNODB;

  
CREATE TABLE pai (
 id SMALLINT PRIMARY KEY,
 nome_pai VARCHAR(50)
);

CREATE TABLE filho (
 id SMALLINT AUTO_INCREMENT PRIMARY KEY,
 nome_filho VARCHAR(50),
 pai_id SMALLINT,
 CONSTRAINT fk_id_pai FOREIGN KEY (pai_id)
 REFERENCES pai(id)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);

INSERT INTO pai VALUES (1,'João'), (2,'Mário'), (3,'Renato'), (4,'Emerson'), (5,'André');
INSERT INTO filho (nome_filho, pai_id) VALUES ('João',1), ('Mário',1), ('Renato',3), ('Emerson',4), ('André',3);

SELECT p.pai_id, p.nome_pai, f.id, f.nome_filho
FROM filho f
INNER JOIN pai p
ON f.pai_id = p.id;

DELETE FROM filho
WHERE nome_filho = 'Renato';

Ao excluirmos o filho Renato, seu pai, que também se chama Renato, continuará a existir na tabela de pais

SELECT nome_pai, nome_filho
FROM filho
INNER JOIN pai
ON filho.pai_id = pai.id;
```
Referências
http://www.bosontreinamentos.com.br/mysql/opcoes-de-chave-estrangeira-mysql/
