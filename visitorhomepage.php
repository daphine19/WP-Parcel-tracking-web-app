<?php
include 'connection.php';

//php to search the database and return tracking details and status
if (isset($_GET["trackbtn"])) {
$senderspostcode = trim(filter_input(INPUT_GET, 'senderspostcode', FILTER_SANITIZE_STRING));
$trackingNo = trim(filter_input(INPUT_GET, 'trackingNo', FILTER_SANITIZE_STRING));

if (!empty($senderspostcode) && !empty($trackingNo)) {
$query = "SELECT * FROM `Parcels` WHERE TrackingNumber= '$trackingNo' AND senderspostcode= '$senderspostcode'";
$result = mysqli_query($connection, $query);
if ($result) {

while ($row = mysqli_fetch_assoc($result)) {
$trackingno = $row['TrackingNumber'];
$sendersfullname = $row['sendersFullname'];
$recepientsfullname = $row['recepientfullname'];
$recepientspostcode = $row['recepientpostcode'];
$status = $row['parcelstatus'];

echo "<div class = trackingresult >"
    . "<h3> TRACKING DETAILS </h3>"."<br>"
    . "<p>The parcel details for <span class=firstline>".$trackingno." </span>are:"
        . "<ul>"
        . "<li> Tracking Number: <span class=detail>" .$trackingno. "</span></li>"
        . "<li>Sender's Fullname: <span class=detail>" .$sendersfullname. "</span></li>"
        . "<li>Recepient's Fullname: <span class=detail>" .$recepientsfullname. "</span></li>"
        . "<li>Recepient's postcode: <span class=detail>" .$recepientspostcode. "</span></li>"
        . "<li>Parcel Status: <span style='color:red;'>" .$status. "</span></li>"
        . "</ul>"
    . "</div>";
}
} else {
die(mysqli_error($connection));
echo "The tracking number or postcode you have entered don't exist in the database";

}
} else {
echo "Please fill in both fields to be able to view the details";
}
}
?>

<html>
<head>
    <title>HOMEPAGE</title>
    <meta http-equiv="x-ua-compatible" content="IE=100">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" href = "homepage.css">


</head>
<body>
<div id = "primary navbar">
    <ul>
        <li><a href = "login.php">LOGIN</a></li>
        <li><a href = "signup.php">SIGNUP</a></li>
    </ul>
</div>

    <div id = "tracking">
    <p id="heading"> You can easily Track your parcels with PARCELGO</p>
    <p class="title">Enter your details</p>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <label>Tracking Number</label><br>
        <input type = "text" name="trackingNo" placeholder="Tracking number"><br>
        <label>PostCode</label><br>
        <input type = "text" name="senderspostcode" placeholder="Sender's postcode"><br>
        <button id= track_btn name="trackbtn">Track</button>
    </form>
    </div>

    <div id= "popup">
        <h3>Our services </h3>
        <h4>Delivery options</h4>
        <ol>
            <li>Next Day delivery</li>
            <li>Weekend delivery</li>
            <li>Standard delivery</li>
        </ol>
        <p>we also offer parcel signature</p>
    </div>
</body>
</html>