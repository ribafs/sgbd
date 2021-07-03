# Uso do MySQL pela console

## SHOW DATABASES;

## USE NomeBanco;

## CREATE DATABASE if not exists Nomebanco;

DROP DATABASE nomebd;

## SHOW CREATE DATABASE southwind \G
```sql
CREATE TABLE IF NOT EXISTS products (
         productID    INT UNSIGNED  NOT NULL AUTO_INCREMENT,
         productCode  CHAR(3)       NOT NULL DEFAULT '',
         name         VARCHAR(30)   NOT NULL DEFAULT '',
         quantity     INT UNSIGNED  NOT NULL DEFAULT 0,
         price        DECIMAL(7,2)  NOT NULL DEFAULT 99999.99,
         PRIMARY KEY  (productID)
       );
```
SHOW TABLES;

DESCRIBE nometabela;

SHOW CREATE TABLE products \G
```sql
INSERT INTO products VALUES (1001, 'PEN', 'Pen Red', 5000, 1.23);

-- Insert multiple rows in one command
-- Inserting NULL to the auto_increment column results in max_value + 1
INSERT INTO products VALUES
         (NULL, 'PEN', 'Pen Blue',  8000, 1.25),
         (NULL, 'PEN', 'Pen Black', 2000, 1.25);

-- Insert value to selected columns
-- Missing value for the auto_increment column also results in max_value + 1
INSERT INTO products (productCode, name, quantity, price) VALUES
         ('PEC', 'Pencil 2B', 10000, 0.48),
         ('PEC', 'Pencil 2H', 8000, 0.49);

- Missing columns get their default values
mysql> INSERT INTO products (productCode, name) VALUES ('PEC', 'Pencil HB');

-- 2nd column (productCode) is defined to be NOT NULL
mysql> INSERT INTO products values (NULL, NULL, NULL, NULL, NULL);
```
Usando select sem tabela
```sql
SELECT 1+1;

SELECT NOW();

SELECT 1+1, NOW();

SELECT name, quantity FROM products WHERE quantity <= 2000;

SELECT name, price FROM products WHERE name LIKE 'PENCIL%';

SELECT name, price FROM products WHERE name LIKE 'P__ %';

SELECT * FROM products WHERE quantity >= 5000 AND price < 1.24 AND name LIKE 'Pen %';

SELECT * FROM products WHERE NOT (quantity >= 5000 AND name LIKE 'Pen %');

SELECT * FROM products WHERE name IN ('Pen Red', 'Pen Black');

SELECT * FROM products 
       WHERE (price BETWEEN 1.0 AND 2.0) AND (quantity BETWEEN 1000 AND 2000);

SELECT * FROM products WHERE productCode IS NULL;

SELECT * FROM products WHERE productCode = NULL;

SELECT ... FROM tableName
WHERE criteria
ORDER BY columnA ASC|DESC, columnB ASC|DESC, ...

SELECT * FROM products WHERE name LIKE 'Pen %' ORDER BY price DESC;

SELECT * FROM products WHERE name LIKE 'Pen %' ORDER BY price DESC, quantity;

SELECT * FROM products ORDER BY RAND();

SELECT * FROM products ORDER BY price LIMIT 2;

SELECT productID AS ID, productCode AS Code,
              name AS Description, price AS `Unit Price`  -- Define aliases to be used as display names
       FROM products
       ORDER BY ID;  -- Use alias ID as reference

SELECT CONCAT(productCode, ' - ', name) AS `Product Description`, price FROM products;

SELECT price FROM products;

SELECT DISTINCT price AS `Distinct Price` FROM products;

SELECT DISTINCT price, name FROM products;

SELECT * FROM products ORDER BY productCode, productID;

SELECT * FROM products GROUP BY productCode;

SELECT COUNT(*) AS `Count` FROM products;

SELECT productCode, COUNT(*) FROM products GROUP BY productCode;

SELECT MAX(price), MIN(price), AVG(price), STD(price), SUM(quantity)
       FROM products;
       -- Without GROUP BY - All rows

SELECT productCode, MAX(price) AS `Highest Price`, MIN(price) AS `Lowest Price`
       FROM products
       GROUP BY productCode;

SELECT productCode, MAX(price), MIN(price),
              CAST(AVG(price) AS DECIMAL(7,2)) AS `Average`,
              CAST(STD(price) AS DECIMAL(7,2)) AS `Std Dev`,
              SUM(quantity)
       FROM products
       GROUP BY productCode;
       -- Use CAST(... AS ...) function to format floating-point numbers

SELECT 
          productCode, 
          MAX(price), 
          MIN(price), 
          CAST(AVG(price) AS DECIMAL(7,2)) AS `Average`,
          SUM(quantity)
       FROM products
       GROUP BY productCode
       WITH ROLLUP;        -- Apply aggregate functions to all groups

UPDATE products SET price = price * 1.1;
SELECT * FROM products;

UPDATE products SET quantity = quantity - 100 WHERE name = 'Pen Red';
SELECT * FROM products WHERE name = 'Pen Red';

UPDATE products SET quantity = quantity + 50, price = 1.23 WHERE name = 'Pen Red';   
SELECT * FROM products WHERE name = 'Pen Red';

DELETE FROM products WHERE name LIKE 'Pencil%';
SELECT * FROM products;

DELETE FROM products;   
SELECT * FROM products;

SELECT products.name, price, suppliers.name 
       FROM products 
          JOIN suppliers ON products.supplierID = suppliers.supplierID
       WHERE price < 0.6;

SELECT products.name, price, suppliers.name 
       FROM products, suppliers 
       WHERE products.supplierID = suppliers.supplierID
          AND price < 0.6;

SELECT products.name AS `Product Name`, price, suppliers.name AS `Supplier Name` 
       FROM products 
          JOIN suppliers ON products.supplierID = suppliers.supplierID
       WHERE price < 0.6;

SELECT p.name AS `Product Name`, p.price, s.name AS `Supplier Name` 
       FROM products AS p 
          JOIN suppliers AS s ON p.supplierID = s.supplierID
       WHERE p.price < 0.6;

ALTER TABLE products DROP FOREIGN KEY products_ibfk_1;
SHOW CREATE TABLE products \G
```
Subconsulta
```sql
SELECT suppliers.name from suppliers
       WHERE suppliers.supplierID
          NOT IN (SELECT DISTINCT supplierID from products_suppliers);

SELECT * FROM patients
       WHERE lastVisitDate BETWEEN '2012-09-15' AND CURDATE()
       ORDER BY lastVisitDate;

SELECT * FROM patients
       WHERE YEAR(dateOfBirth) = 2011
       ORDER BY MONTH(dateOfBirth), DAY(dateOfBirth);

SELECT * FROM patients
       WHERE MONTH(dateOfBirth) = MONTH(CURDATE()) 
          AND DAY(dateOfBirth) = DAY(CURDATE());

SELECT name, dateOfBirth, TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) AS age 
       FROM patients
       ORDER BY age, dateOfBirth;

SELECT name, lastVisitDate FROM patients
       WHERE TIMESTAMPDIFF(DAY, lastVisitDate, CURDATE()) > 60;

SELECT name, lastVisitDate FROM patients
       WHERE TO_DAYS(CURDATE()) - TO_DAYS(lastVisitDate) > 60;

SELECT * FROM patients 
       WHERE dateOfBirth > DATE_SUB(CURDATE(), INTERVAL 18 YEAR);

UPDATE patients 
       SET nextVisitDate = DATE_ADD(CURDATE(), INTERVAL 6 MONTH)
       WHERE name = 'Ali';

select now(), curdate(), curtime();

SELECT DAYNAME(NOW()), MONTHNAME(NOW()), DAYOFWEEK(NOW()), DAYOFYEAR(NOW());

      SELECT DATE_ADD('2012-01-31', INTERVAL 5 DAY);
       
      SELECT DATE_SUB('2012-01-31', INTERVAL 2 MONTH);

SELECT DATEDIFF('2012-02-01', '2012-01-28');

SELECT TIMESTAMPDIFF(DAY, '2012-02-01', '2012-01-28');

SELECT TO_DAYS('2012-01-31');

SELECT FROM_DAYS(734899);

      SELECT DATE_FORMAT('2012-01-01', '%W %D %M %Y');
      Sunday 1st January 2012
             -- %W: Weekday name
             -- %D: Day with suffix
             -- %M: Month name
             -- %Y: 4-digit year
             -- The format specifiers are case-sensitive

SELECT DATE_FORMAT('2011-12-31 23:59:30', '%W %D %M %Y %r');

       CREATE TABLE IF NOT EXISTS `datetime_arena` (
                 `description`  VARCHAR(50)  DEFAULT NULL,
                 `cDateTime`    DATETIME     DEFAULT '1000-01-01  00:00:00',
                 `cDate`        DATE         DEFAULT '1000-01-01 ',
                 `cTime`        TIME         DEFAULT '00:00:00',
                 `cYear`        YEAR         DEFAULT '0000',
                 `cYear2`       YEAR(2)      DEFAULT '0000',
                 `cTimeStamp`   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
              );
        
DESCRIBE `datetime_arena`;

       INSERT INTO `datetime_arena` 
                 (`description`, `cDateTime`, `cDate`, `cTime`, `cYear`, `cYear2`)
              VALUES 
                 ('Manual Entry', '2001-01-01 23:59:59', '2002-02-02', '12:30:30', '2004', '05');
          
       mysql> SELECT * FROM `datetime_arena` WHERE description='Manual Entry';

       UPDATE `datetime_arena` SET `cYear2`='99' WHERE description='Manual Entry';
          
       mysql> SELECT * FROM `datetime_arena` WHERE description='Manual Entry';

       INSERT INTO `datetime_arena` 
                 (`description`, `cDateTime`, `cDate`, `cTime`, `cYear`, `cYear2`)
              VALUES 
                 ('Built-in Functions', now(), curdate(), curtime(), now(), now());
          
       mysql> SELECT * FROM `datetime_arena` WHERE description='Built-in Functions';

       INSERT INTO `datetime_arena`
                 (`description`, `cDateTime`, `cDate`, `cTime`, `cYear`, `cYear2`)
              VALUES 
                 ('Error Input', '2001-13-31 23:59:59', '2002-13-31', '12:61:61', '99999', '999');
          
       mysql> SELECT * FROM `datetime_arena` WHERE description='Error Input';

SELECT `cDate`, `cDate` + INTERVAL 30 DAY, `cDate` + INTERVAL 1 MONTH FROM `datetime_arena`;

CREATE VIEW supplier_view
       AS
       SELECT suppliers.name as `Supplier Name`, products.name as `Product Name`
       FROM products 
          JOIN suppliers ON products.productID = products_suppliers.productID
          JOIN products_suppliers ON suppliers.supplierID = products_suppliers.supplierID;

CREATE VIEW patient_view
       AS
       SELECT 
          patientID AS ID, 
          name AS Name, 
          dateOfBirth AS DOB,
          TIMESTAMPDIFF(YEAR, dateOfBirth, NOW()) AS Age
       FROM patients
       ORDER BY Age, DOB;
 
mysql> SELECT * FROM patient_view WHERE Name LIKE 'A%'

SELECT * FROM patient_view WHERE age >= 18;

CREATE TABLE torneios ( 
nome varchar(30), 
vitorias real, 
melhor real, 
tamanho real 
);

INSERT INTO torneios (nome, vitorias, melhor, tamanho) 
VALUES ('Dolly', '7', '245', '8.5'), 
('Etta', '4', '283', '9'), 
('Irma', '9', '266', '7'), 
('Barbara', '2', '197', '7.5'), 
('Gladys', '13', '273', '8');

CREATE TABLE refeicoes ( 
nome varchar(30), 
data_nascimento date, 
entrada varchar(30), 
acompanhamento varchar(30), 
sobremesa varchar(30) 
);

INSERT INTO refeicoes (nome, data_nascimento, entrada, acompanhamento, sobremesa) 
VALUES ('Dolly', '1946-01-19', 'steak', 'salad', 'cake'), 
('Etta', '1938-01-25', 'chicken', 'fries', 'ice cream'), 
('Irma', '1941-02-18', 'tofu', 'fries', 'cake'), 
('Barbara', '1948-12-25', 'tofu', 'salad', 'ice cream'), 
('Gladys', '1944-05-28', 'steak', 'fries', 'ice cream');

SELECT nome, vitorias FROM torneios 
WHERE vitorias > (
SELECT vitorias FROM torneios WHERE nome = 'Barbara'
);

SELECT nome, tamanho FROM torneios AS t 
WHERE vitorias > (
SELECT AVG(vitorias) FROM torneios WHERE tamanho = t.tamanho
);

SELECT nome, entrada, acompanhamento, sobremesa 
FROM refeicoes 
WHERE nome = (SELECT nome FROM torneios 
WHERE vitorias = (SELECT MAX(vitorias) FROM torneios));

SELECT
`name`,
`age`
FROM
`people`
WHERE
`age` > 22
LIMIT
1
```
Listar tamanho de todos os bd em MBs
```sql
SELECT table_schema "DB Name",
Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB"
FROM information_schema.tables
GROUP BY table_schema;
```
Checar se registro não existe antes de inserir
```sql
       INSERT INTO Table1 (column1, column2)
         SELECT ?, ? FROM dual 
           WHERE NOT EXISTS (SELECT * FROM Table1 WHERE column1 = ? AND column2 = ?)
```

Mostrar com quem não entro em contato há mais de 30 dias

SELECT pk_id_pessoa, nome_razao_social, folowup_ultimo FROM `pessoa` WHERE folowup_ultimo < DATE_ADD(NOW(), INTERVAL -30 day)


Referência
https://www.ntu.edu.sg/home/ehchua/programming/sql/SQLMisc.html
https://www.ntu.edu.sg/home/ehchua/programming/sql/MySQL_Beginner.html

