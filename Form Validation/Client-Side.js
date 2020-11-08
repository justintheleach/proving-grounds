/*
  Client-Side JavaScript Form Validation by Justin Leach 11/8/20
  
  This is an example of using JavaScript to validate input of a signup form.
  The form is asking for:
    -First name (which I refer to in my variables as "fname")
    -Last name (which I refer to in my variables as "lname")
    -Email address
    -Password
    -Repeat password
  By default, the submit button is disabled until all fields are valid.
  
  There is also text that will show up if there is invalid input, which tells the user what the problem is.
  The advantage of using JavaScript for form validation is that you can give the user feedback before they submit a form.
  Less PHP and SQL requests to the database.  Another layer of security.
  
  But you must also perform server-side validation.  I did mine with PHP, which is located within this same "Form Validation" folder.
  
  My HTML: */
        <form class="signup" action="../php/signup.php" method="post"> //when user clicks submit it runs a PHP script
                <h2>Create an Account</h2>
                <p>An account will give you access to purchase our book</p>

                <label for="email">First Name:</label><br /> //I use label elements to indicate what each input box is asking for
                    <input type="text" name="fname" /><br />
                    <p class="hiddenverify">*Please enter your first name</p> 
                <label for="email">Last Name:</label><br /> //^the class of all <p> elements is set to "hiddenverify" to hide the errors by default - they will show when a user starts typing
                    <input type="text" name="lname" /><br />
                    <p class="hiddenverify">*Please enter your last name</p>
                <label for="email">Email Address:</label><br />
                    <input type="text" name="email" /><br />
                    <p class="hiddenverify">*Please enter a valid email address</p>
                <label for="password">Password:</label><br />
                    <input type="password" name="password" /><br />
                    <p class="hiddenverify">*Your password must be at least six characters</p>
                <label for="password">Repeat Password:</label><br />
                    <input type="password" name="repeatpassword" /><br />
                    <p class="hiddenverify">*Passwords don't match</p><br />
                <button type="submit" class="disabled" name="submit">Create Account</button> 
            </form>

/*My CSS has styling for the classes - but I won't paste it here.  I have gone ahead and styled all "hidden" classes to have a display:none.  
The disabled button is also grey while the active button is colored to match the theme of my website.

My JavaScript: */

    if (document.querySelector(".signup")) { //This will check to make sure we are on the sign up page - I have the form's class set to "signup"

        /*function that checks if every input is valid and updates the submit button*/
        function signupValidate() {
            let submitbutton = document.querySelector(".formcontainer form button"); //gets the submit button
            if (fnamevalidate == true && lnamevalidate == true && emailvalidate == true && passwordvalidate == true && repeatpasswordvalidate == true) {//if everything is good, enable submit
                submitbutton.disabled = false; //if everything is valid, enable the button
                submitbutton.className = "submit"; //change class for styling purposes
            }
            else { //there are inputs where are not valid
                submitbutton.disabled = true; //disable button
                submitbutton.className = "disabled"; //change the class for styling purposes
            }
        }

        /*set all variables*/
        let fnameinput = document.querySelectorAll(".formcontainer form input")[0];//get first name input box
        let lnameinput = document.querySelectorAll(".formcontainer form input")[1];//get last name input box
        let emailinput = document.querySelectorAll(".formcontainer form input")[2];//get email input box
        let passwordinput = document.querySelectorAll(".formcontainer form input")[3];//get password input box
        let repeatpasswordinput = document.querySelectorAll(".formcontainer form input")[4];//get repeat password input box
        let fnamevalidate = false; //these are booleans I will use to store whether or not an input is valid
        let lnamevalidate = false;
        let emailvalidate = false;
        let passwordvalidate = false;
        let repeatpasswordvalidate = false;
        let fnametext = document.querySelectorAll(".hiddenverify")[0]; //get error text for fname
        let lnametext = document.querySelectorAll(".hiddenverify")[1]; //get error text for lname
        let emailtext = document.querySelectorAll(".hiddenverify")[2]; //get error text for email
        let passwordtext = document.querySelectorAll(".hiddenverify")[3]; //get error text for password
        let repeatpasswordtext = document.querySelectorAll(".hiddenverify")[4]; //get error text for repeat password

        /*fname validate*/
        fnameinput.addEventListener("input", function fnameinputtext(event) { //adds an event listener which fires every time a user makes a change
            if (fnameinput.value != "" && fnameinput.value.length <= 128) { //it should validate if it is not empty and if it is less than 128 characters
                fnamevalidate = true;
                fnametext.className = "hiddenverify"; //change class to hide the error in case there is one showing
            }
            else { //it doesn't validate
                fnamevalidate = false;
                if (fnameinput.value.length > 128) { //too large
                    fnametext.innerHTML = "*Must be under 128 characters"; //set error text to match the error
                }
                else { //name not entered
                    fnametext.innerHTML = "*Please enter your first name"; //set error text to match the error
                }
                fnametext.className = "verify" //changes class to show the error
            }
            signupValidate(); //call the function to check if everything is valid - then updates the submit button
        });

        /*lname validate*/
        lnameinput.addEventListener("input", function lnameinputtext(event) { //adds an event listener which fires every time a user makes a change
            if (lnameinput.value != "" && lnameinput.value.length <= 128) { //it should validate if it is not empty and if it is less than 128 characters
                lnamevalidate = true;
                lnametext.className = "hiddenverify"; //change class to hide the error in case there is one showing
            }
            else { //it doesn't validate
                lnamevalidate = false;
                if (lnameinput.value.length > 128) { //too large
                    lnametext.innerHTML = "*Must be under 128 characters"; //set error text to match the error
                }
                else { //name not entered
                    lnametext.innerHTML = "*Please enter your last name"; //set error text to match the error
                }
                lnametext.className = "verify" //change class to show the error
            }
            signupValidate(); //call the function to check if everything is valid - then updates the submit button
        });

        /*validate email*/
        emailinput.addEventListener("input", function emailinputtext(event) { //adds an event listener which fires every time a user makes a change
            /*needs to validate for '@' and '.'*/
            let atvalidate = false; //boolean for validating the @ symbol
            let dotvalidate = false; //boolean for validating the . symbol
            for (let i = 0; i < emailinput.value.length; i++) { //goes through the entire email input box
                if (emailinput.value[i] == '@') { //user enters an @
                    atvalidate = true;
                    break; //exit loop
                }
                else { //@ not entered - invalid email
                    atvalidate = false;
                }
            }
            for (let i = 0; i < emailinput.value.length; i++) { //goes through entire email input box
                if (emailinput.value[i] == '.') { //user enters a .
                    dotvalidate = true;
                    break; //exit loop
                }
                else { //. not entered - invalid
                    dotvalidate = false;
                }
            }
            if (atvalidate == true && dotvalidate == true && emailinput.value.length <= 128) { //if there is an @ and a . and the email is not too long
                emailvalidate = true;
                emailtext.className = "hiddenverify"; //change the class to hide the error text, if showing
            }
            else { //email is not valid
                emailvalidate = false;
                if (emailinput.value.length > 128) { //too large
                    emailtext.innerHTML = "*Must be under 128 characters"; //change error text
                }
                else { //name not entered
                    emailtext.innerHTML = "*Please enter a valid email address"; //change error text
                }
                emailtext.className = "verify"; //change class to show error
            }
            signupValidate(); //call the function to check if everything is valid - then updates the submit button
        });

        /*password validate*/
        passwordinput.addEventListener("input", function passwordinputtext(event) { //adds an event listener which fires every time a user makes a change
            if (passwordinput.value.length >= 6 && passwordinput.value.length <= 128) { //it should validate if the password is between 6 and 128 characters
                passwordvalidate = true;
                passwordtext.className = "hiddenverify"; //change class to hide error in case it is showing
            }
            else { //it doesn't validate
                passwordvalidate = false;
                if (passwordinput.value.length > 128) { //too large
                    passwordtext.innerHTML = "*Must be under 128 characters"; //shows error message
                }
                else { //name not entered
                    passwordtext.innerHTML = "*Must be at least 6 characters"; //shows error message
                }
                passwordtext.className = "verify" //change class to show error message
            }
            /*now test to match it with the repeated password*/
            if (passwordinput.value == repeatpasswordinput.value) { //it should validate if they are the same
                repeatpasswordvalidate = true;
                repeatpasswordtext.className = "hiddenverify"; //hide error in case it is showing
            }
            else { //the passwords do not match
                repeatpasswordvalidate = false;
                repeatpasswordtext.className = "verify" //change class to show the error message
            }
            signupValidate(); //call the function to check if everything is valid - then updates the submit button
        });

        /*repeat password validate*/
        repeatpasswordinput.addEventListener("input", function repeatpasswordinputtext(event) { //adds an event listener which fires every time a user makes a change
            if (passwordinput.value == repeatpasswordinput.value) { //it should validate if they are the same
                repeatpasswordvalidate = true;
                repeatpasswordtext.className = "hiddenverify"; //hide error in case it is showing
            }
            else { //the passwords do not match
                repeatpasswordvalidate = false;
                repeatpasswordtext.className = "verify" //change class to show the error message
            }
            signupValidate(); //call the function to check if everything is valid - then updates the submit button
        });
    }

