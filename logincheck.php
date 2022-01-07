<?php
// If we don't already have an open session open one
if(empty($_SESSION)){
    session_start();
}

// If a user isn't logged in
if ((empty($_SESSION["login"])) || ($_SESSION["login"] != true)){

    $_SESSION["loginRequired"] = true;
    header("Location: visitorhomepage.php");
    exit;
}
?>
