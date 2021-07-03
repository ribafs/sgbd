<?php
/**
 * @author-name Ribamar FS
 * @copyright	Copyright (C) 2010 Ribamar FS.
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 * backup genérico is free and open source software. This version may have been modified 
 * pursuant to the GNU General Public License, and as distributed it includes or is 
 * open source software licenses. 
 */

if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}

$dbhost = $_POST['dbhost'];

if(isset($dbhost)){
	$dbuser = $_POST['dbuser'];
	$dbpass = $_POST['dbpass'];
	$database = $_POST['database'];

	// backup all tables in db	
	function backup_tables($dbhost,$dbuser,$dbpass,$database){
    	//connect to db
    	$link = mysqli_connect($dbhost,$dbuser,$dbpass);
        mysqli_set_charset($link,'utf8');
        mysqli_select_db($link,$database);

        //get all of the tables
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');

        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }

        //disable foreign keys (to avoid errors)
        $return = 'SET FOREIGN_KEY_CHECKS=0;' . "\r\n";
        $return.= 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . "\r\n";
        $return.= 'SET AUTOCOMMIT=0;' . "\r\n";
        $return.= 'START TRANSACTION;' . "\r\n";

        //cycle through
        foreach($tables as $table)
        {
            $result = mysqli_query($link, 'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);
            $num_rows = mysqli_num_rows($result);
            $i_row = 0;

            //$return.= 'DROP TABLE '.$table.';'; 
            $row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n"; 

            if ($num_rows !== 0) {
                $row3 = mysqli_fetch_fields($result);
                $return.= 'INSERT INTO '.$table.'( ';
                foreach ($row3 as $th) 
                { 
                    $return.= '`'.$th->name.'`, '; 
                }
                $return = substr($return, 0, -2);
                $return.= ' ) VALUES';

                for ($i = 0; $i < $num_fields; $i++) 
                {
                    while($row = mysqli_fetch_row($result))
                    {
                        $return.="\n(";
                        for($j=0; $j<$num_fields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = preg_replace("#\n#","\\n",$row[$j]);
                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                            if ($j<($num_fields-1)) { $return.= ','; }
                        }
                        if (++$i_row == $num_rows) {
                            $return.= ");"; // last row
                        } else {
                            $return.= "),"; // not last row
                        }   
                    }
                }
            }
            $return.="\n\n\n";
        }

        // enable foreign keys
        $return .= 'SET FOREIGN_KEY_CHECKS=1;' . "\r\n";
        $return.= 'COMMIT;';

		$date = date("Y-m-d_H");
        //save file
        $dir = dirname(__FILE__);
		$db = $dir.DS.'backup'.DS.$database.'_'.$date.'.sql';

        $handle = fopen($db,'w+');
        fwrite($handle,$return);
        fclose($handle);
	}

	// Créditos: http://stackoverflow.com/questions/81934/easy-way-to-export-a-sql-table-without-access-to-the-server-or-phpmyadmin
	// \Backup dpo Banco

// Call function backup_tables
backup_tables($dbhost,$dbuser,$dbpass,$database);

// Year-mount-day_Hour
$date = date("Y-m-d_H");
$dir = dirname($_SERVER['PHP_SELF']);
$host = $_SERVER['HTTP_HOST'].DS.$dir;
$db_file = 'http://'.$host.DS.'backup'.DS.$database.'_'.$date.'.sql';	
?>

<html>
    <head>
        <title>Backup Database</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet" type="text/css">
		<script>
		var language = window.navigator.userLanguage || window.navigator.language;
		if(language == "pt-BR"){
		var suc='Backup do banco bem Sucedido';
		var db='Banco de dados';
		var ret='Voltar';
		}else{
		var suc='Database Backup Successuful';
		var db='Database';
		var ret='Return';
		}
		</script>                
    </head>
    <body>
    <div class="container">    
            <div class="row">            
	                <div class="col-lg-8 col-lg-offset-2">
<h2 align="center"><script>document.writeln(suc);</script></h2>
<h3 align="center">Download<br><a href="<?php print $db_file;?>"><script>document.writeln(db);</script></a></h3>
<br>
<h4 align="center"><a href="index.html"><script>document.writeln(ret);</script></a></h4>
</body>
<?php
}
?>
