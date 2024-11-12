<?php
define('CURRENCY', '$');
define('WEB_URL', 'http://127.0.0.1/apartment/');
define('ROOT_PATH', 'C:\xampp\htdocs\apartment/');


define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ams_db');
$link = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or die(mysql_error());mysql_select_db(DB_DATABASE, $link) or die(mysql_error());?>