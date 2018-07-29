<?php

	ob_start(); //turns on output buffering
	session_start();

	$timezone = date_default_timezone_set("America/Sao_Paulo");

	$con = mysqli_connect("localhost", "root", "", "songify");  //variable that connects to the database
	//mysqli_connect("server", "(default)username", "password", "mysql database name")

	if(mysqli_connect_errno()) {

		echo "Failed to connect: " . mysqli_connect_errno();
	}

?>