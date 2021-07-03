# Metadados

information_schema é um banco de dados virtual do MySQL que armazena informações de metadados de todos os bancos de dados MySQL.

Referências
https://www.thegeekstuff.com/2008/11/overview-of-mysql-information_schema-database-with-practical-examples/ 
https://www.noelherrick.com/blog/intro-to-mysql-information-schema
https://www.navicat.com/en/company/aboutus/blog/1054-using-the-mysql-information-schema 
https://www.cmi.ac.in/~madhavan/courses/databases10/mysql-5.0-reference-manual/information-schema.html
```sql
use information_schema;
show tables;
```
Tables_in_information_schema
```sql
CHARACTER_SETS
COLLATIONS
COLLATION_CHARACTER_SET_APPLICABILITY
COLUMNS
COLUMN_PRIVILEGES
ENGINES
EVENTS
FILES
GLOBAL_STATUS
GLOBAL_VARIABLES
KEY_COLUMN_USAGE
OPTIMIZER_TRACE
PARAMETERS
PARTITIONS
PLUGINS
PROCESSLIST
PROFILING
REFERENTIAL_CONSTRAINTS
ROUTINES
SCHEMATA
SCHEMA_PRIVILEGES
SESSION_STATUS
SESSION_VARIABLES
STATISTICS
TABLES
TABLESPACES
TABLE_CONSTRAINTS
TABLE_PRIVILEGES
TRIGGERS
USER_PRIVILEGES
VIEWS
INNODB_LOCKS
INNODB_TRX
INNODB_SYS_DATAFILES
INNODB_FT_CONFIG
INNODB_SYS_VIRTUAL
INNODB_CMP
INNODB_FT_BEING_DELETED
INNODB_CMP_RESET
INNODB_CMP_PER_INDEX
INNODB_CMPMEM_RESET
INNODB_FT_DELETED
INNODB_BUFFER_PAGE_LRU
INNODB_LOCK_WAITS
INNODB_TEMP_TABLE_INFO
INNODB_SYS_INDEXES
INNODB_SYS_TABLES
INNODB_SYS_FIELDS
INNODB_CMP_PER_INDEX_RESET
INNODB_BUFFER_PAGE
INNODB_FT_DEFAULT_STOPWORD
INNODB_FT_INDEX_TABLE
INNODB_FT_INDEX_CACHE
INNODB_SYS_TABLESPACES
INNODB_METRICS
INNODB_SYS_FOREIGN_COLS
INNODB_CMPMEM
INNODB_BUFFER_POOL_STATS
INNODB_SYS_COLUMNS
INNODB_SYS_FOREIGN
INNODB_SYS_TABLESTATS
```
Selecionar tabelas com mais de 100 registros:

select concat(table_schema,'.',table_name) as table_name,table_rows from information_schema.tables where table_rows > 100 order by table_rows desc;

Listar todas as tabelas sem uma PK
```sql
SELECT CONCAT(t.table_name,".",t.table_schema) as table_name
FROM information_schema.TABLES t
LEFT JOIN information_schema.TABLE_CONSTRAINTS tc
ON t.table_schema = tc.table_schema
AND t.table_name = tc.table_name
AND tc.constraint_type = 'PRIMARY KEY'
WHERE tc.constraint_name IS NULL
AND t.table_type = 'BASE TABLE';
```
Listar top 5 maiores tabelas:
```sql
SELECT concat(table_schema,'.',table_name) table_name, concat(round(data_length/(1024*1024),2),'M') data_length FROM information_schema.TABLES ORDER BY data_length DESC LIMIT 5;
```
Listar as top 10 tabelas
```sql
Select
   Concat(table_schema, '.', table_name) As "Name"
  ,Concat(Round(table_rows / 1000000, 2), 'M') As "Rows"
  ,Concat(Round(data_length / ( 1024 * 1024 * 1024 ), 2), 'G') As "Row Size"
  ,Concat(Round(index_length / ( 1024 * 1024 * 1024 ), 2), 'G') As "Index Size"
  ,Concat(Round(( data_length + index_length ) / ( 1024 * 1024 * 1024 ), 2), 'G') As "Total"
  ,Round(index_length / data_length, 2) "Row / Index Ratio"
From information_schema.TABLES
Order By data_length + index_length DESC
Limit 10;
```
```sql
SELECT table_name, table_type, engine
FROM information_schema.tables
WHERE table_schema = 'estoque'
ORDER BY table_name; 
```
Informações
```sql
SELECT * FROM INFORMATION_SCHEMA.STATISTICS
  WHERE table_name = 'produtos'
  AND table_schema = 'estoque'

TABLE_CATALOG	TABLE_SCHEMA	TABLE_NAME	NON_UNIQUE	INDEX_SCHEMA	INDEX_NAME	SEQ_IN_INDEX	COLUMN_NAME	COLLATION	CARDINALITY	SUB_PART	PACKED	NULLABLE	INDEX_TYPE	COMMENT	INDEX_COMMENT
def	estoque	produtos	0	estoque	PRIMARY	1	id	A	11	NULL	NULL		BTREE		
def	estoque	produtos	0	estoque	descricao	1	descricao	A	11	NULL	NULL		BTREE		
```
