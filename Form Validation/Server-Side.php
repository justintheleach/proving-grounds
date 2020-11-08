

<?php

/*Get data*/
if (isset($_POST["submit"])) {
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$passwordrepeat = $_POST["repeatpassword"];

  /*database*/
  
  /*functions*/
  
  
	/*empty input anywhere*/
	if (emptyInputSignup($fname, $lname, $email, $password, $passwordrepeat) !== false) {
		header("location: ../accounts/signup.html?error=emptyinput");
		exit();
	}
	
	/*first name*/
	if (invalidName($fname) !== false) {
		header("location: ../accounts/signup.html?error=invalidfname");
		exit();
	}
	
	/*last name*/
	if (invalidName($lname) !== false) {
		header("location: ../accounts/signup.html?error=invalidlname");
		exit();
	}
	
	/*email*/
	if (invalidEmail($email) !== false) {
		header("location: ../accounts/signup.html?error=invalidemail");
		exit();
	}
	
	/*password*/
	if (invalidPassword($password) !== false) {
		header("location: ../accounts/signup.html?error=invalidpassword");
		exit();
	}
	
	/*repeat password*/
	if (invalidPasswordRepeat($password, $passwordrepeat) !== false) {
		header("location: ../accounts/signup.html?error=invalidpasswordrepeat");
		exit();
	}
	
	/*email in use*/
	if (emailExists($conn, $email) !== false) {
		header("location: ../accounts/signup.html?error=emailexists");
		exit();
	}
	
	/*create the user in the database*/
	createUser($conn, $fname, $lname, $email, $password);
}	
else {
	header("location: ../accounts/signup.html");
	exit();
}
