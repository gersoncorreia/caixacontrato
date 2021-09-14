<?php
//diretorio do sistema
define("BASEPATH",dirname(__FILE__)."/");
define("BASEURL","http://localhost/caixacontrato/");
define("ADMURL",BASEURL."painel.php");
define("CLASSEPATH","classes/");
define("MODULOSPATH","modulos/");
define("CSSPATH","css/");
define("JSPATH","js/");

//banco de dados
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "db_caixa_contrato");

$constates = array('BASEPATH','BASEURL','ADMURL','CLASSEPATH', 'MODULOSPATH','CSSPATH','JSPATH','DBHOST','DBUSER','DBPASS','DBNAME');
?>
