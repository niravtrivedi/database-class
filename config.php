<?php
define('DB_USER','root');
define('DB_PASS','ganesha');
define('DB_HOST','localhost');
define('DB_NAME','chat');

$DbRes = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die(mysql_error());
$TableRes =  mysql_select_db(DB_NAME) or die(mysql_error());




?>
