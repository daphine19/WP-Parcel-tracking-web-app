<?php
include "connection.php";
include "logincheck.php";

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
                    . "<li>Recepient's Fullname: <span class=detail>".$recepientsfullname. "</span></li>"
                    . "<li>Recepient's postcode: <span class=detail>".$recepientspostcode. "</span></li>"
                    . "<li>Parcel Status: <span style='color:red;'>".$status. "</span></li>"
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
    <link rel = "stylesheet" href = "myParcels.css">

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
<div id = "Secondary Navbar">
    <ul>
        <li><a href="adminhomepage.php">HOMEPAGE</a></li>
        <li><a href="allParcels.php">ALL PARCELS</a></li>
        <li><a href="createparcel.php">CREATE</a></li>
        <li><a href="adminhomepage.php#tracking">TRACK</a></li>

    </ul>
</div>
<div id="container">
    <div id = "tracking">
        <p id="heading"> You can easily Track your parcels with PARCELGO</p>
        <p class="title">Enter your details</p>
        <form>
            <label>Tracking Number</label>
            <input type = "text" name="trackingNo" placeholder="Tracking number"><br>
            <label>PostCode</label>
            <input type = "text" name="senderspostcode" placeholder="Sender's postcode"><br>
            <button id = track_btn name="trackbtn"> Track </button></a>
        </form>
    </div>

    <div id= "popup" class="services">
        <h3>Our services </h3>
        <h4>Delivery options</h4>
        <ol>
            <li>Next Day delivery</li>
            <li>Weekend delivery</li>
            <li>Standard delivery</li>
        </ol>
        <p>we also offer parcel signature</p>
    </div>

    <div id = "popup" class="view">
        <h3>View your parcels</h3>
        <div id= "vieweditparcel">
            <table class="table">
                <thead>
                <tr>
                    <th>Tracking Number</th>
                    <th>Sender's postcode</th>
                    <th>Recipient's postcode</th>
                    <th>Status</th>
                    <th>Operations</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // this code is for displaying the data from the database into the table or viewing part details of a registeredusers' parcel.
                $userid = $_SESSION['userDetails']['Userid'];
                $query = "SELECT TrackingNumber, senderspostcode,recepientpostcode, parcelstatus  FROM `Parcels` WHERE Userid = '$userid' ";
                $result = mysqli_query($connection, $query);
                if($result){
                    while($row=mysqli_fetch_assoc($result)){
                        $trackingno = $row['TrackingNumber'];
                        $senderspostcode = $row['senderspostcode'];
                        $recepientpostcode = $row['recepientpostcode'];
                        $parcelstatus = $row['parcelstatus'];
                        echo '<tr>
       
                    <td data-label = "Tracking Number">'.$trackingno.'</td>
                    <td data-label = "Sender\'s postcode">'.$senderspostcode.'</td>
                    <td data-label = "Recepient\'s postcode">'.$recepientpostcode.'</td>
                    <td data-label = "status">'.$parcelstatus.'</td>
                    <td data-label = "Operations">
                        <button><a href = "fullview.php?viewid='.$trackingno.'" class="status">VIEW</a></button>
                        <button><a href = "updateParcel.php?updateid='.$trackingno.'" class="status">UPDATE</a></button>
                     </td>
                </tr>';
                    }
                }
                ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php
mysqli_close($connection);
?>

</body>
</html>
