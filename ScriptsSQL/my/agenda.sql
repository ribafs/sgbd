-- Banco agenda
create table amigos(
    id int primary key auto_increment,
    nome char(50) not null,
    email char(60),
    nascimento date null default,
	endereco VARCHAR(255),
	fone VARCHAR(15),
	celular VARCHAR(15),
	foto VARCHAR(35),
	obs TEXT    
);

create table compromissos(
    id int primary key auto_increment,
    nome char(50) not null,
    compromisso text not null,
	data date not null,
	obs TEXT    
);

-- echo $this->Form->create('FormName', ['type' => 'file']);
