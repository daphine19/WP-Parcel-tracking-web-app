<?php
include 'connection.php';
session_start();

   // get all the fields from the form and trim them as well.
if (isset($_POST["signupSubmit"])) {
    $fname =trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
    $lname = trim(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING));
    $emailaddress = trim(filter_input(INPUT_POST, 'emailaddress', FILTER_SANITIZE_STRING));
    $password =trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    $confirmPassword =  trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING));

   // if its an admin they will have to contact the website manager to set them as admin in the database. one admin has been created in the database
    $role='registereduser';

    // check the two passwords input match
    if($password!=$confirmPassword) {
        $errors[] ="Passwords dont match";
    }
    else {
        //hash the password to make it more secure
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    //check if email already exists
    $email_check_query = "SELECT * FROM RegisteredUsers WHERE emailaddress = '$emailaddress' LIMIT 1";
    $results = mysqli_query($connection, $email_check_query);
    if(mysqli_num_rows($results) > 0){
        $errors[]= "Email address already exists";
    }
    // check all fields individually and that none are empty
        if (empty($fname)) {
            $errors[] = "First name is missing.";
        }
        if (empty($lname)) {
            $errors[] = "Last name is missing";
        }
        if (empty($emailaddress)) {
            $errors[] = "Emailaddress is missing.";
            }
        if (empty($password)) {
            $errors[] = "Password is missing.";
        }

    // check that non of the fields have been left empty or else display the relevant errors.
    if (!empty($errors)) {
        echo "<div class='alertbox'>"
        ."<ol><p>Please fix the errors below before trying to continue</p>";

    // Loop through the errors array and add each one to the array
    foreach ($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ol></div>";
             
    }
    else{
        $query = "INSERT INTO `RegisteredUsers` (Firstname,Lastname,emailaddress,password, role)
                 VALUES ('$fname','$lname','$emailaddress','$hashedPassword','$role')";
        $result = mysqli_query($connection, $query);
        if ($result == true) {
            //echo "<p> You have successfully signed up!!!</p>";
           header('Location: registeredhomepage.php');
        }
        else {
            die(mysqli_error($connection));
        }
       
    }

}

?>
<html>
<head>
    <title>SIGNUP PAGE</title>
    <meta http-equiv="x-ua-compatible" content="IE=100">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="viewpoint" content="width=device-width", initial-scale="1.0">
    <link rel = "stylesheet" href = "signup_login.css">
    <link rel = "stylesheet" href = "createparcel.css">

</head>
<body>
<div id="wrapper">
    <div class="title"><span>SIGNUP</span></div>
    <div>
        <form id="signup" class = "input" action="signup.php" method="post">
            <label>First name</label><br>
            <input type = "text" name= "fname" class ="input-feild" required><br>
            <label>Last name</label><br>
            <input type = "text" name= "lname" class ="input-feild" required><br>
            <label>Email Address</label><br>
            <input type = "text" name= "emailaddress" class ="input-feild" required><br>
            <label>Password</label><br>
            <input type = password name = "password" class ="input-feild" id= "password" required><br>
            <label>Confirm Password</label><br>
            <input type = password name = "confirmPassword" class ="input-feild" id= "confirmpassword" required><br>
            <input name= "signupSubmit" type ="submit" value="Sign up">
            <div class=" link">Already a member? <a href = "login.php">Login here</a></div>
        </form>
    </div>
</div>
<?php
mysqli_close($connection);
?>
</body>
</html>

