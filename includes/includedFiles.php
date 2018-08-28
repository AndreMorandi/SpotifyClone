<?php 

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	//comes with ajax request
	include("includes/classes/User.php");
	include("includes/handlers/config.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");
	include("includes/classes/Playlists.php");

	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	}
	else {
		echo "Username not passed. See openPage() function";
	}

}
else {

	include("includes/header.php");
	include("includes/footer.php");

	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('$url')</script>";
	exit();
}

?>