CREATE OR REPLACE FUNCTION CPF_Validar(par_cpf varchar(11)) RETURNS integer AS $$
-- ROTINA DE VALIDAÇÃO DE CPF
-- Conversão para o PL/ PGSQL: Cláudio Leopoldino - http://postgresqlbr.blogspot.com/
-- Algoritmo original: http://webmasters.neting.com/msg07743.html
-- Retorna 1 para CPF correto.
DECLARE
x real;
y real; --Variável temporária
soma integer;
dig1 integer; --Primeiro dígito do CPF
dig2 integer; --Segundo dígito do CPF
len integer; -- Tamanho do CPF
contloop integer; --Contador para loop
val_par_cpf varchar(11); --Valor do parâmetro
BEGIN
-- Teste do tamanho da string de entrada
IF char_length(par_cpf) = 11 THEN
ELSE
RAISE NOTICE 'Formato inválido: %',$1;
RETURN 0;
END IF;
-- Inicialização
x := 0;
soma := 0;
dig1 := 0;
dig2 := 0;
contloop := 0;
val_par_cpf := $1; --Atribuição do parâmetro a uma variável interna
len := char_length(val_par_cpf);
x := len -1;
--Loop de multiplicação - dígito 1
contloop :=1;
WHILE contloop <= (len -2) LOOP
y := CAST(substring(val_par_cpf from contloop for 1) AS NUMERIC);
soma := soma + ( y * x);
x := x - 1;
contloop := contloop +1;
END LOOP;
dig1 := 11 - CAST((soma % 11) AS INTEGER);
if (dig1 = 10) THEN dig1 :=0 ; END IF;
if (dig1 = 11) THEN dig1 :=0 ; END IF;

-- Dígito 2
x := 11; soma :=0;
contloop :=1;
WHILE contloop <= (len -1) LOOP
soma := soma + CAST((substring(val_par_cpf FROM contloop FOR 1)) AS REAL) * x;
x := x - 1;
contloop := contloop +1;
END LOOP;
dig2 := 11 - CAST ((soma % 11) AS INTEGER);
IF (dig2 = 10) THEN dig2 := 0; END IF;
IF (dig2 = 11) THEN dig2 := 0; END IF;
--Teste do CPF
IF ((dig1 || '' || dig2) = substring(val_par_cpf FROM len-1 FOR 2)) THEN
RETURN 1;
ELSE
RAISE NOTICE 'DV do CPF Inválido: %',$1;
RETURN 0;
END IF;
END;
$$ LANGUAGE PLPGSQL;
