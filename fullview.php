
<?php
include 'connection.php';
include "logincheck.php";
?>
<html>
    <head>
        <title>FULL ENTRY VIEW</title>
        <meta http-equiv="x-ua-compatible" content="IE=100">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel = "stylesheet" href = "allParcels.css">
        <link rel = "stylesheet" href = "fullview.css">
        <link rel = "stylesheet" href = "homepage.css">


    </head>
    <body>
    <div id = "primary navbar">
        <ul>
            <li><?php // this code will help us say hi then the name of the person thats logged in, if it chooses to work.
                echo "<p> Hello "
                    . " " .ucwords($_SESSION['userDetails']['Firstname'])
                    . " " .ucwords($_SESSION["userDetails"]["Lastname"]). ""
                    . "</p>";
                ?></li>
            <li><a href = "logout.php">Logout</a></li>
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
<?php
$trackingNo = $_GET['viewid'];// retrieve from when someone clicks view

$query = "SELECT * FROM `Parcels` WHERE TrackingNumber= '$trackingNo'";
$result = mysqli_query($connection, $query);
if($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        //var_dump($row);
        $trackingno = $row['TrackingNumber'];
        $parcelContent = $row['parcelContent'];
        $deliveryOption = $row['deliveryOption'];
        $parcelSignature = $row['parcelsignature'];
        $sendersfullname = $row['sendersFullname'];
        $sendersemail = $row['sendersemail'];
        $senderstelephone = $row['senderstelephone'];
        $senderspostcode = $row['senderspostcode'];
        $sendershousenumber = $row['sendershousenumber'];
        $sendersstreetname = $row['sendersstreetname'];
        $recepientsfullname = $row['recepientfullname'];
        $recepientsemail = $row['recepientemailaddress'];
        $recepientstelephone = $row['recepienttelephone'];
        $recepientspostcode = $row['recepientpostcode'];
        $recepientshousenumber = $row['recepienthousenumber'];
        $recepientsstreetname = $row['recepientstreetname'];
        $status=$row['parcelstatus'];

        // will have to add some styling when everything comes together.
        echo
            "<div class= fullviewdesign>"
            ."<p>The parcel details for <span class=firstline>" .$trackingNo. "</span> are: "
            ."<ul>"
            ."<li>Tracking Number: <span class=detail>".$trackingno."</span></li>"
            ."<li>Parcel Status: <span class=detail>".$status."</span></li>"
            ."<h3> Parcel Details.</h3>"
            ."<li> Parcel content: <span class=detail>" .$parcelContent . "</span></li>"
            ."<li>Delivery Option: <span class=detail> " .$deliveryOption. "</span></li>"
            ."<li>Parcel Signature: <span class=detail>" .$parcelSignature. "</span></li>"
            ."<h3> Sender's Details.</h3>"
            ."<li>Fullname: <span class=detail>" .$sendersfullname. "</span></li>"
            ."<li>Email:< span class=detail>" .$sendersemail. "</span></li>"
            . "<li>Telephone: <span class=detail>" .$senderstelephone. "</span></li>"
            ."<li>Postcode: <span class=detail>" .$senderspostcode. "</span></li>"
            ."<li>House number: <span class=detail>" .$sendershousenumber. "</span></li>"
            ."<li>Street name: <span class=detail>" .$sendersstreetname. "</span></li>"
            ."<h3> Recepient's Details.</h3>"
            ."<li>Fullname: <span class=detail>" .$recepientsfullname. "</span></li>"
            ."<li>Email: <span class=detail>" .$recepientsemail. "</span></li>"
            ."<li>Telephone: <span class=detail>" .$recepientstelephone. "</span></li>"
            ."<li>Postcode: <span class=detail>" .$recepientspostcode. "</span></li>"
            ."<li>House number: <span class=detail>" .$recepientshousenumber. "</span></li>"
            ."<li>Streetname: <span class=detail>".$recepientsstreetname. "</span></li>"
            ."</ul>"
            ."</div>";
          }
}
else {
    echo "<p>Getting parcel full details failed.</p>";
    die(mysqli_error($connection));
}
mysqli_close($connection);
?>
    </body>
</html>
