<?php

    ini_set('mssql.charset', 'UTF-8');
	$serverName = "192.168.20.29,1433"; //serverName ???? Server
	$connectionInfo = array( "Database"=>"smartbooking_company", "UID"=>"sa", "PWD"=>"Support@0049#", "CharacterSet" => "UTF-8");

	$conn = sqlsrv_connect($serverName,$connectionInfo);
	
	if( $conn ) {		
		echo "Connection established.<br />";
	}else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	// session_name("broker");
	// session_start();

	// session_name("broker");

?>