<?php  

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText); //remove all HTML tags
	$inputText = str_replace(" ", "", $inputText); //get rid of spaces
	return $inputText;
}

function sanitizeFormString($inputText) {
	$inputText = strip_tags($inputText); 
	$inputText = str_replace(" ", "", $inputText); 
	$inputText = ucfirst(strtolower($inputText)); //converts all the string to lower case than uppercase the first character
	return $inputText;
}

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText); //remove all HTML tags
	return $inputText;
}

if(isset($_POST['registerButton'])) { /*The $_POST variable is used to collect values from a form with method="post". The NAMES OF THE FORM FIELDS will automatically be the ID keys in the $_POST array.*/

	//Register button was pressed
	$username = sanitizeFormUsername($_POST['username']);
	$firstName = sanitizeFormString($_POST['firstName']);
	$lastName = sanitizeFormString($_POST['lastName']);
	$email = sanitizeFormString($_POST['email']);
	$email2 = sanitizeFormString($_POST['email2']);
	$password = sanitizeFormPassword($_POST['password']);
	$password2 = sanitizeFormPassword($_POST['password2']);

	//Register function --> validate form fields
	$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);
	
	if($wasSuccessful){
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
}
	 	
?>