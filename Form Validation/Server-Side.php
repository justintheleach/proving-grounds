  Server-Side PHP Form Validation by Justin Leach 11/8/20
  
  This is an example of using PHP to validate input of a signup form.
  The form is asking for:
    -First name
    -Last name
    -Email address
    -Password
    -Repeat password
  By default, the submit button is disabled until all fields are valid (handled with JavaScript, which is included as "Client-Side.js" within this folder).
 
  There is also text that will show up if there is invalid input, which tells the user what the problem is.
  The advantage of using PHP for form validation is security and streamlined access to the database.  You can also pass along errors in the URL.
  
  But you must also perform client-side validation.  I did mine with JavaScript, which is located within this same "Form Validation" folder.

  This example does not include creating the new user account in your database.  It only validates the form data.
  
  My HTML:
            <form class="signup" action="../php/signup.php" method="post"> //when the user clicks the submit button it runs a PHP script, which I explain below my HTML
                <h2>Create an Account</h2>
                <p>An account will give you access to purchase our book</p>
                <?php //I have some PHP here to check for a few errors which I can pass through the URL in case my client-side validation did not catch them
                    if (isset($_GET["error"])) { //checks if there is an error
                        if ($_GET["error"] == "emptyinput") { //general error of an empty input somewhere
                            echo '<p class="verifycenter">*Please fill in all fields</p>'; //shows error message
                        }
                        if ($_GET["error"] == "stmtfailed") { //more complicated error involving connected to the database
                            echo '<p class="verifycenter">*Error: Please try again - if this persists <a href="../info/contact.html">contact support</a></p>'; //shows error
                        }
                    }
                ?>
                <label for="email">First Name:</label><br />
                <input type="text" name="fname" /><br />
                <p class="hiddenverify">*Please enter your first name</p> //all of these <p> with class of "hiddenverify" are handled through JavaScript validation
                <?php //this PHP checks for an invalid first name, in case my client-side JavaScript did not catch it
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidfname") {
                            echo '<p class ="verifyright">*Names must only include letters</p>'; //in this case the verify message is "floated" to the right to stand out from my javascript one
                        }
                    }
                ?>
                <label for="email">Last Name:</label><br />
                <input type="text" name="lname" /><br />
                <p class="hiddenverify">*Please enter your last name</p>
                <?php //this PHP checks for an invalid last name, in case my client-side JavaScript did not catch it
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidlname") {
                            echo '<p class="verifyright">*Names must only include letters</p>';
                        }
                    }
                ?>
                <label for="email">Email Address:</label><br />
                <input type="text" name="email" /><br />
                <p class="hiddenverify">*Please enter a valid email address</p>
                <?php //this PHP checks for an invalid email, in case my client-side JavaScript did not catch it
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidemail") { //this happens when the built-in email validation function in PHP returns an error
                            echo '<p class="verifyright">*Email is invalid</p>';
                        }
                        if ($_GET["error"] == "emailexists") { //this happens when the email exists in the database
                            echo '<p class="verifyright">*Email already used</p>';
                        }
                    }
                ?>
                <label for="password">Password:</label><br />
                <input type="password" name="password" /><br />
                <p class="hiddenverify">*Your password must be at least six characters</p>
                <?php //this PHP checks for an invalid password, in case my client-side JavaScript did not catch it
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidpassword") {
                            echo '<p class="verifyright">*Invalid password</p>';
                        }
                    }
                ?>
                <label for="password">Repeat Password:</label><br />
                <input type="password" name="repeatpassword" /><br />
                <p class="hiddenverify">*Passwords don't match</p><br />
                <?php //this PHP checks to make sure the passwords match, in case my client-side JavaScript did not catch it
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "invalidpasswordrepeat") {
                            echo '<p class="verifyright">*Passwords did not match</p>';
                        }
                    }
                ?>
                <button type="submit" class="disabled" name="submit">Create Account</button>
            </form>

  My CSS has styling for the classes - but I won't paste it here.  I have gone ahead and styled all "hidden" classes to have a display:none.  
  The disabled button is also grey while the active button is colored to match the theme of my website.

  My PHP, which is accessed through the "post" method of the HTML form: 

<?php

	/*Get data from the form*/
	if (isset($_POST["submit"])) { //makes sure the user has accessed this script through the "post" method of the signup form
		/*set up the variables*/
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$passwordrepeat = $_POST["repeatpassword"];

	  	/*set up a connection to the database (not neccessary for pure form validation but neccessary in this case to make sure the email address is not already
		in our database*/
		$serverName = "localhost"; //this information can be found through your PHPmyAdmin
		$dBUserName = "root";
		$dBPassword = "";
		$dBName = "test";

		$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName); //using the built-in mysqli function to form a connection

		if (!$conn) { //if the connection fails
			die("Connection failed: " . mysqli_connect_error()); // stop the PHP script and show error
		}
		
	  	/*functions - each of these will be called and each function returns a boolean to reflect whether or not their input was valid*/
		function emptyInputSignup($fname, $lname, $email, $password, $passwordrepeat) {	//test for empty fields (JavaScript should catch this)
			$result; //set up a boolean which will return true or false when the function is called
			if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($passwordrepeat)) { //if any of them are empty
				$result = true; //return true
			}
			else { //they are all populated
				$result = false; //return false
			}
			return $result; //returns true (an error) or false (no errors)
		}
		
		function invalidName($name) { //we will use this to test both first name and last name
			$result;
			if (!preg_match("/^[a-zA-Z]*$/", $name)) { //tests for an error - makes sure the user only entered letters
				$result = true; //the input included a number or special character
			}
			else {
				$result = false; //input was all letters
			}
			return $result; //returns true (an error) or false (no errors)
		}
		
		function invalidEmail($email) { //tests for invalid email (JavaScript should have also caught this)
			$result;
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //uses the built-in email validation function 
				$result = true; //bad email
			}
			else {
				$result = false; //good email
			}
			return $result; //returns true (an error) or false (no errors)
		}
		
		function emailExists($conn, $email) { //checks the database to see if the email exists
			$sql = "SELECT * FROM users WHERE usersEmail = ?;"; //sql query (prepared statement replaces user input with question marks)
			$stmt = mysqli_stmt_init($conn); //built-in prepared statement function
			if (!mysqli_stmt_prepare($stmt, $sql)) { //if it fails
				header("location: ../accounts/signup.html?error=stmtfailed"); //send them back to the signup form, error reflects what happened
				exit(); //exit the PHP script
			}

			mysqli_stmt_bind_param($stmt, "s", $email);//combine email input with the prepared statement
			mysqli_stmt_execute($stmt);//execute statement

			$resultData = mysqli_stmt_get_result($stmt); //attempt to get the email address from the database
			if ($row = mysqli_fetch_assoc($resultData)) { //if it does exist in the database,
				result = true; //the email exists, return true (an error)
			}
			else {
				$result = false; //email does not exist in the database
			}
			return $result;

			mysqli_stmt_close($stmt);//close statement
		}
		
		function invalidPassword($password) { //tests for invalid password (JavaScript should have caught this)
			$result;
			if (strlen($password) < 6) { //the password is less than six characters
				$result = true; //return an error
			}
			else {
				$result = false; //password is okay - no error
			}
			return $result;
		}
		
		function invalidPasswordRepeat($password, $passwordrepeat) { //tests to make sure the passwords match
			$result;
			if ($password !== $passwordrepeat) { //if they don't match
				$result = true; //return an error
			}
			else {
				$result = false; //return no errors if they match
			}
			return $result;
		}

		/*Call the functions - each function returns either true (an error happened) or false (it is valid).  I always check for errors first.*/
		if (emptyInputSignup($fname, $lname, $email, $password, $passwordrepeat) !== false) { //calls the empty input function and passes everything
			header("location: ../accounts/signup.html?error=emptyinput"); //sends them back to the signup page if there is empty input
			exit(); //closes the script
		}
		
		if (invalidName($fname) !== false) { //calls the invalid name function and passes the first name
			header("location: ../accounts/signup.html?error=invalidfname"); //sends them back to the signup page if the first name is invalid
			exit(); //closes the script
		}

		if (invalidName($lname) !== false) { //calls the invalid name function and passes the last name
			header("location: ../accounts/signup.html?error=invalidlname"); //sends them back to the signup page if the last name is invalid
			exit(); //closes the script
		}

		if (invalidEmail($email) !== false) { //calls the invalid email function and passes the email
			header("location: ../accounts/signup.html?error=invalidemail"); //sends them back to the signup page if the email is invalid
			exit(); //closes the script
		}

		if (emailExists($conn, $email) !== false) { //calls the function to check if the email exists - passes the connection to the database and the email
			header("location: ../accounts/signup.html?error=emailexists"); //sends them back to the signup page if the email exists
			exit(); //closes the script
		}
		
		if (invalidPassword($password) !== false) { //calls the invalid password function and passes the password
			header("location: ../accounts/signup.html?error=invalidpassword"); //sends them back to the signup page if the password is invalid
			exit(); //closes the script
		}

		if (invalidPasswordRepeat($password, $passwordrepeat) !== false) { //calls the password matching function and passes the password and the repeated password
			header("location: ../accounts/signup.html?error=invalidpasswordrepeat"); //sends them back to the signup page if the passwords don't match
			exit(); //closes the script
		}

		/*from here it would make sense to add the user to your users table in your database - or do whatever other action you would like to do now that
		everything has been validated.*/
	}	
	else { //the user did not access this script through the "post" method of the signup form
		header("location: ../accounts/signup.html"); //send them to the signup page
		exit(); //close the script
	}
