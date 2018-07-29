<?php

if(isset($_POST['loginButton'])) {  /*The $_POST variable is used to collect values from a form with method="post". The NAMES OF THE FORM FIELDS will automatically be the ID keys in the $_POST array.*/
	
	//Login button was pressed
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($username, $password);

	if($result){
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}

}

?>