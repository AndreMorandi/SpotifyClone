<?php

	include("includes/handlers/config.php");

	//session_destroy();

	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
	}else{
		header("Location: register.php");	
	}

	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");

?>





<!DOCTYPE html>
<html><head>

	<title>Welcome to Songify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><!--JQuery Hosted-->
	<script src="assets/js/script.js"></script>

<body>

	<div id="mainContainer">


		<div id="topContainer">
			
			<?php include("includes/navBarContainer.php");  ?>

			<div id="mainViewContainer">
				
				<div id="mainContent">