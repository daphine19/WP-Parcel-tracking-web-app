
<?php
include 'connection.php';

session_start();

if(isset($_POST["loginSubmit"])){
    if((!empty($_POST['emailaddress'])) && (!empty($_POST["password"]))){
        $emailaddress = trim(filter_input(INPUT_POST, 'emailaddress', FILTER_SANITIZE_STRING));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

        $query = "SELECT * FROM RegisteredUsers WHERE emailaddress='".$emailaddress."'";
        $result = mysqli_query($connection,$query);
        if($result) {
            $found = mysqli_num_rows($result);
            if ($found > 0) {
                $userDetails = mysqli_fetch_assoc($result);
                if(password_verify($password, $userDetails['password'])) {// verify the received password and the one in the database match.

                    $_SESSION['login'] = true;
                    $_SESSION['userDetails'] = $userDetails;// create session to store userdetails.
                    echo $userDetails;
                    while($userDetails){
                        if($userDetails['role']== "admin"){
                            header('Location:adminhomepage.php');
                        }
                        elseif($userDetails['role']== "registereduser"){
                            header('Location:registeredhomepage.php');
                        }
                        else{
                            header('Location:visitorhomepage.php');
                        }
                    }
                   $referrer = (
                        (!empty($_SERVER["HTTP_REFERER"]))
                        //check where the user is and redirect them respectifully
                        && (
                            (substr($_SERVER["HTTP_REFERER"], -1) != "/") &&
                            (substr($_SERVER["HTTP_REFERER"], -9) != "login.php") &&
                            (substr($_SERVER["HTTP_REFERER"], -10) != "logout.php") &&
                            ($_SERVER["HTTP_REFERER"] != "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])
                        )
                    ) ? $_SERVER["HTTP_REFERER"] : "registeredhomepage.php";
                    header("Location: " .$referrer);
                    echo $referrer;
                } else {
                    $loginFailed = true;
                   $loginError = "<p style='color: red'>Wrong user name and password combination!</p>";
                }
            } else {
                $loginFailed = true;
                $loginError = "<p style='color: red'>No data found for user in the database!</p>";

            }
        }
        else {
            $loginFailed = true;
            $loginError = "<p>The query to check username and password are correct has failed</p>";

        }
    }else {
        $loginFailed = true;
        $loginError = "<p style='color: red'>Username and/or password has not been added to the form.</p>";
    }
}
?>

<html>
<head>
    <title>LOGIN PAGE</title>
    <link rel = "stylesheet" href = "signup_login.css">
    <meta http-equiv="x-ua-compatible" content="IE=100">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
</head>
<body>

<?php
//the login error is displayed here.
if($loginFailed){
    echo $loginError;
}
?>
<div id= "wrapper">
    <div class="title"><span>LOGIN</span></div>
    <div class="login">
        <form id= "login" method="post" action="login.php">
            <label>Email Address</label><br>
            <input type = "text" name= "emailaddress" class ="input-feild" required><br>
            <label>Password</label><br>
            <input type = "password" name = "password" class ="input-feild" required><br>
            <input name="loginSubmit" type ="submit" value="Login">
            <div class="link">Not a member? <a href = "signup.php">SignUp now</a></div>
        </form>
    </div>
</div>
<?php
mysqli_close($connection);
?>
</body>
</html>
