<?php 

define('DBHOST', "localhost");
define('DBUSER', "root");
define('DBPWD', "root");
define('DBNAME', "ksu_courses");

$db_link = false;

function conn_db() {
	global $db_link;
	
	if(!$db_link) {
		$db_link = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);
		
		if (mysqli_connect_errno())
			die (mysqli_connect_errno());
	}
}

function close_db() {
	global $db_link;
    if(!$db_link)
		mysqli_close($db_link);
}