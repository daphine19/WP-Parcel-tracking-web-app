<?php
include 'connection.php';
include "logincheck.php";
session_start();

if (isset($_POST["createSubmit"])) {
    //help with sanitising the input data
    $parcelContent = trim(filter_input(INPUT_POST, 'parcelcontent', FILTER_SANITIZE_STRING));
    $deliveryOption = trim(filter_input(INPUT_POST, 'deliveryoption', FILTER_SANITIZE_STRING));
    $parcelSignature = trim(filter_input(INPUT_POST, 'parcelsignature', FILTER_SANITIZE_STRING));
    $sendersfullname = trim(filter_input(INPUT_POST, 'sendersfullname', FILTER_SANITIZE_STRING));
    $sendersemail = trim(filter_input(INPUT_POST, 'sendersemailaddress', FILTER_SANITIZE_STRING));
    $senderstelephone = trim(filter_input(INPUT_POST, 'senderstelephone', FILTER_SANITIZE_STRING));
    $senderspostcode = trim(filter_input(INPUT_POST, 'senderspostcode', FILTER_SANITIZE_STRING));
    $sendershousenumber = trim(filter_input(INPUT_POST, 'sendershousenumber', FILTER_SANITIZE_NUMBER_INT));
    $sendersstreetname = trim(filter_input(INPUT_POST, 'sendersstreetname', FILTER_SANITIZE_STRING));
    $recepientsfullname = trim(filter_input(INPUT_POST, 'recepientsfullname', FILTER_SANITIZE_STRING));
    $recepientsemail = trim(filter_input(INPUT_POST, 'recepientsemailaddress', FILTER_SANITIZE_STRING));
    $recepientstelephone = trim(filter_input(INPUT_POST, 'recepientstelephone', FILTER_SANITIZE_STRING));
    $recepientspostcode = trim(filter_input(INPUT_POST, 'recepientspostcode', FILTER_SANITIZE_STRING));
    $recepientshousenumber = trim(filter_input(INPUT_POST, 'recepientshousenumber', FILTER_SANITIZE_NUMBER_INT));
    $recepientsstreetname = trim(filter_input(INPUT_POST, 'recepientsstreetname', FILTER_SANITIZE_STRING));

    //connects to the user that is currently logged in
    $userid = $_SESSION['userDetails']['Userid'];

    //this is for admin use only
    $status = 'Created';// should set the default to "we have got it"
    $date = date("Y/m/d");//adds the date to the day the parcel was created
    $trackingno = (uniqid("T")); //generates a unique tracking number for each parcel.

    // check one by one that all values have been input
    if (empty($parcelContent)) {
        $errors[] = "Please insert what is in the parcel.";
    }
    if (empty($deliveryOption)) {
        $errors[] = "Delivery option preference missing.";
    }
    if (empty($parcelSignature)) {
        $errors[] = "Parcel signature preference missing";
    }
    if (empty($sendersfullname)) {
        $errors[] = "Sender's fullname missing";
    }
    if (empty($sendersemail)) {
        $errors[] = "Sender's email missing";
    }
    if (empty($senderstelephone)) {
        $errors[] = "Sender's telephone missing";
    }
    if (empty($senderspostcode)) {
        $errors[] = "Sender's postcode missing";
    }
    if (empty($sendershousenumber)) {
        $errors[] = "Sender's housenumber missing";
    }
    if (empty($sendersstreetname)) {
        $errors[] = "Sender's street name missing";
    }
    if (empty($recepientsfullname)) {
        $errors[] = "Recepient's fullname missing";
    }
    if (empty($recepientsemail)) {
        $errors[] = "Recepient's email missing";
    }
    if (empty($recepientstelephone)) {
        $errors[] = "Recepient's telephone missing";
    }
    if (empty($recepientspostcode)) {
        $errors[] = "Recepient's postcode missing";
    }
    if (empty($recepientshousenumber)) {
        $errors[] = "Recepient's housenumber missing";
    }
    if (empty($recepientsstreetname)) {
        $errors[] = "Recepient's streetname missing";
    }

// If there are any errors output them to the screen
    if (!empty($errors)) {
        echo "<div class='alertbox'>"
        ."<ol><p>Please fix the errors below before trying to continue</p>";

        // Loop through the errors array and add each one to the array
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ol></div>";
    }
    else
        {
        //no errors found go on and excute the query
        $query = "INSERT INTO `Parcels` (TrackingNumber,Userid,parceldate,parcelstatus,parcelContent,deliveryoption,parcelsignature,sendersFullname,sendersemail,senderstelephone,
                senderspostcode, sendershousenumber,sendersstreetname,recepientfullname,recepientemailaddress,recepienttelephone,recepientpostcode,recepienthousenumber,recepientstreetname)
                 VALUES ('$trackingno','$userid','$date','$status','$parcelContent','$deliveryOption','$parcelSignature',
                  '$sendersfullname','$sendersemail','$senderstelephone','$senderspostcode','$sendershousenumber','$sendersstreetname', 
               '$recepientsfullname','$recepientsemail','$recepientstelephone','$recepientspostcode','$recepientshousenumber','$recepientsstreetname')";

        $result = mysqli_query($connection, $query);
        if ($result == true) {
            echo "<div class='successmessagebox'>"
                . "<p style='text-align: center'>Thank you for creating your parcel with ParcelGo.The tracking number is:</p>"
                . "<br><span>" . $trackingno . "</span></div>";
        }
        else {
            die(mysqli_error($connection));
        }
    }
}
?>
<html>
<head>
    <title>PARCEL CREATE PAGE</title>
    <meta http-equiv="x-ua-compatible" content="IE=100">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" href = "createparcel.css">
    <link rel = "stylesheet" href = "homepage.css">


</head>
<body>
<div id = "primary navbar">
    <ul>
        <li><?php // this code will help us say hi then the name of the person thats logged in, if it chooses to work.
            echo "<p> Hello "
                . " " .ucwords($_SESSION['userDetails']['Firstname'])
                . " " .ucwords($_SESSION["userDetails"]["Lastname"]) . ""
                . "</p>";
            ?></li>
        <li><a href = "logout.php">logout</a></li>
    </ul>
</div>
<div id = "Navbar">
    <ul>
        <?php
        $currentuser = $_SESSION['userDetails']['role'];
        if($currentuser == 'admin'){
            echo "<li><a href=". "adminhomepage.php".">HOMEPAGE</a></li>";
            echo "<li><a href=". "adminhomepage.php#vieweditparcel".">VIEW</a></li>";
            echo "<li><a href=". "adminhomepage.php#tracking".">TRACK</a></li>";
        }
        else{
            echo "<li><a href=". "registeredhomepage.php".">HOMEPAGE</a></li>";
            echo "<li><a href=". "registeredhomepage.php#vieweditparcel".">VIEW</a></li>";
            echo "<li><a href=". "registeredhomepage.php#tracking".">TRACK</a></li>";
        }
        ?>
        <li><a href="createparcel.php">CREATE</a></li>
    </ul>

</div>
<div class="container">
    <form action="createparcel.php" class="form" method="post">
        <div class = "category">
            <h3 class = "headings"> PARCEL DETAILS</h3>
            <label>What is in the parcel?</label><br>
            <input type = "text" name = "parcelcontent"><br>

            <h4>Delivery option</h4>

            <input type = "radio"  name="deliveryoption" value="standard">
            <label>Standard delivery</label><br>
            <input type = "radio"  name="deliveryoption" value="nextday">
            <label>Next day Delivery</label><br>
            <input type = "radio"  name="deliveryoption" value="weekend">
            <label>Weekend delivery</label><br>

            <h4>Parcel signature</h4>
            <input type = "radio"  name= "parcelsignature" value="yes">
            <label>Add signature</label><br>
            <input type = "radio"  name= "parcelsignature" value="no">
            <label>No thanks </label><br>
        </div>

        <div class = "category">
            <h3 class = "headings">SENDER'S DETAILS</h3>
            <h4>Contact information</h4>

            <label>Full name </label><br>
            <input type = "text" name="sendersfullname"><br>
            <label>Email address </label>
            <input type = "email" name="sendersemailaddress"><br>
            <label>Telephone </label>
            <input type = "tel" name="senderstelephone"><br>

            <h4>Address details </h4>
            <label>PostCode </label><br>
            <input type = "text" name="senderspostcode"><br>
            <label>House Number </label><br>
            <input type = "number" name="sendershousenumber"><br>
            <label>Street name </label><br>
            <input type = "text" name="sendersstreetname"><br>

        </div>

        <div class = "category">
            <h3 class = "headings">RECIPIENT'S DETAILS</h3>
            <h4>Contact information</h4>

            <label>Full name </label><br>
            <input type = "text"  name="recepientsfullname"><br>
            <label>Email address </label><br>
            <input type = "email"  name="recepientsemailaddress"><br>
            <label>Telephone </label><br>
            <input type = "tel"  name="recepientstelephone"><br>

            <h4>Address details </h4>
            <label>PostCode </label><br>
            <input type = "text" name="recepientspostcode"><br>
            <label>House Number </label><br>
            <input type = "number" name="recepientshousenumber"><br>
            <label>Street name </label><br>
            <input type = "text"  name="recepientsstreetname"><br>
            <button name= createSubmit type="submit" class="button">Create</button>

        </div>
    </form>
</div>
<?php
mysqli_close($connection);
?>
</body>
</html>
