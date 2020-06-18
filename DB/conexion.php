<?php

include_once 'config.php';

function ConnectDB()
{
    $mysqli = new mysqli(host, user, pass , BD);
    	
	if ($mysqli->connect_errno) {
		die("Connection failed: " . mysqli_connect_error()); 
	}
	//echo "Connected successfully";
	return $mysqli;
}

?>