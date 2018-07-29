<?php

	include("includes/handlers/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($fieldName){
		if(isset($_POST[$fieldName])){
			echo $_POST[$fieldName];
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Spotify</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<meta charset="utf-8">
</head>
<body>

	<div id="inputContainer" class="container">

		<div class="pb-2 mt-4 mb-2 border-bottom">
        <a href="register.php" class="navbar-brand">
        	Spotify
        </a>
     	</div>


		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
			<div class="form-group">
				<?php echo $account->getError(Constants::$loginFailed); ?>
				<label for="loginUsername">Username</label>
				<input id="loginUsername" type="text" name="loginUsername" placeholder="Username" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="loginPassword">Password</label>
				<input id="loginPassword" type="password" name="loginPassword" placeholder="Password" class="form-control" required>
			</div>

			<button type="submit" name="loginButton" class="btn btn-primary">LOG IN</button>
		</form>



		<form id="registerForm" action="register.php" method="POST">
			<h2>Create you free account</h2>
			<div class="form-group">
				<?php echo $account->getError(Constants::$usernameCharacters); ?>
				<?php echo $account->getError(Constants::$usernameTaken); ?>
				<label for="username">Username</label>
				<input id="username" type="text" name="username" placeholder="Username" class="form-control" value="<?php getInputValue('username') ?>" required>
			</div>

			<div class="form-group">
				<?php echo $account->getError(Constants::$firstNameCharacters); ?>
				<?php echo $account->getError(Constants::$firstNameNotAlpha); ?>
				<label for="firstName">First Name</label>
				<input id="firstName" type="text" name="firstName" placeholder="First name" class="form-control" value="<?php getInputValue('firstName') ?>" required>
			</div>

			<div class="form-group">
				<?php echo $account->getError(Constants::$lastNameCharacters); ?>
				<?php echo $account->getError(Constants::$lastNameNotAlpha); ?>
				<label for="lastName">Last Name</label>
				<input id="lastName" type="text" name="lastName" placeholder="Last name" class="form-control" value="<?php getInputValue('lastName') ?>" required>
			</div>

			<div class="form-group">
				<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
				<?php echo $account->getError(Constants::$emailInvalid); ?>
				<?php echo $account->getError(Constants::$emailTaken); ?>
				<label for="email">Email</label>
				<input id="email" type="email" name="email" placeholder="Email" class="form-control" value="<?php getInputValue('email') ?>"required>
			</div>

			<div class="form-group">
				<label for="email2">Confirm Email</label>
				<input id="email2" type="email" name="email2" placeholder="Confirm Email" class="form-control" value="<?php getInputValue('email2') ?>" required>
			</div>

			<div class="form-group">
				<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
				<?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
				<?php echo $account->getError(Constants::$passwordCharacters); ?>
				<label for="password">Password</label>
				<input id="password" type="password" name="password" placeholder="Password" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="password2">Confirm Password</label>
				<input id="password2" type="password" name="password2" placeholder="Confirm Password" class="form-control" required>
			</div>

			<button type="submit" name="registerButton" class="btn btn-primary">SIGN UP</button>
		</form>

	</div>









	<script src="http://chancejs.com/chance.min.js"></script>
	<!--Compiled and minified JavaScript-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="main.js"></script>

</body>
</html>