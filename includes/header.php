<?php

	include("includes/handlers/config.php");

	//session_destroy();

	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
		echo "<script> userLoggedIn = '$userLoggedIn'; </script>";
	}else{
		header("Location: register.php");	
	} ///TO DO : FINISH LOGIN/REGISTER CONFIGURATION

	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");

?>





<!DOCTYPE html>
<html>
<head>
	<title>Hello, World!</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="assets/css/styleTest.css"><!--TO DO -> CHANGE FILE NAME--->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--Font-Awesome for HTML icons-->
	<link rel="icon" type="text/css" href="assets/images/favicon.png">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!--JQuery hosted-->
	<script src="assets/js/jsTest.js"></script><!--TO DO -> CHANGE FILE NAME--->

</head>
<body>

	<div id="mainContainer">

		<div id="topContainer">

			<!--     NAV BAR     -->
			<?php include("includes/navBarContainer.php") ?>



			<!--     MAIN VIEW CONTAINER - MAIN CONTENT     -->
			<div id="mainViewContainer">

				<div id="mainContent"> <!--ALL THE CONTENT OF THE SITE WILL BE BELOW HERE (IN ANOTHER FILE)-->
