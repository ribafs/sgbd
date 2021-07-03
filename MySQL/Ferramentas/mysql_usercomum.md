# Acessar mysql com user diferente do sudo

Por padrão, as vesões atuais do mysql/maraidb somente podem ser acessadas usando

sudo mysql -uroot

Dessa forma não podemos criar um banco e passar para um aplicativo.

Precisamos permitir que o mysql seja acessado sem o uso do suudo com:

mysql -uroot -p

## Idealmente crie um usuário para cada aplicativo.

Para isso siga os passos abaixo:

```bash
sudo systemctl stop mysql
sudo mkdir -p /var/run/mysqld
sudo chown mysql:mysql /var/run/mysqld
sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &
exit;
mysql -u root
USE mysql;
update user set plugin="mysql_native_password";
flush privileges;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'senhaforte';
quit
sudo pkill mysqld
sudo systemctl start mysql
mysql -uroot
```
Créditos:

https://solidfoundationwebdev.com/blog/posts/how-to-fix-mysql-error-1524-hy000-plugin-auth_socket-is-not-loaded-in-mysql-5-7

https://linuxconfig.org/how-to-reset-root-mysql-mariadb-password-on-ubuntu-20-04-focal-fossa-linux

## Criar usuário e banco para ele

Cou criar o banco portaldb e user portalus com todos os poderes sobre ele mas somente sobre ele e no localhost.
```bash
create database portaldb CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'portalus'@'localhost' IDENTIFIED BY 'senhaforte';
grant all privileges on portaldb.* to 'portalus'@'localhost';
FLUSH PRIVILEGES;
\q
```
