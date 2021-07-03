# Criar dois bancos 

E para cada um criar um usuário com todos os poderes mas somente sobre o seu banco

Impostante. O usuário deve ter este formato:

'nome'@'host'

Laravel
```bash
mysql -uroot -p
create database acldb CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'aclus'@'localhost' IDENTIFIED BY 'senhaforte';
grant all privileges on acldb.* to 'aclus'@'localhost';
FLUSH PRIVILEGES;
```
Joomla
```bash
create database portaldb CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'portalus'@'localhost' IDENTIFIED BY 'senhaforte';
grant all privileges on portaldb.* to 'portalus'@'localhost';
FLUSH PRIVILEGES;
\q
```

