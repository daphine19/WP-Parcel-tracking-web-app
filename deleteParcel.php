<?php
include 'connection.php';
include "logincheck.php";

// this is php code for deleting a parcel.

if(isset($_GET['deleteid'])){

    $trackingNo = $_GET['deleteid'];
//var_dump($trackingNo);
    $query = "DELETE FROM `Parcels` WHERE TrackingNumber ='$trackingNo'";
    $result = mysqli_query($connection, $query);
    // the success meessage has been placed in the HTML part.

?>
<html>
<head>
    <title>PARCEL CREATE PAGE</title>
    <meta http-equiv="x-ua-compatible" content="IE=100">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel = "stylesheet" href = "createparcel.css">
    <link rel = "stylesheet" href = "homepage.css">
    <link rel = "stylesheet" href = "admin.css">

</head>
<body>
<div id = "primary navbar">
    <ul>
        <li><?php // this code will help us say hi then the name of the person thats logged in, if it chooses to work.
            echo "<p> Hello "
                . " " .ucwords( $_SESSION['userDetails']['Firstname'])
                . " " .ucwords( $_SESSION["userDetails"]["Lastname"]). ""
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
        }
        else{
            echo "<li><a href=". "registeredhomepage.php".">HOMEPAGE</a></li>";
        }
        ?>
        <li><a href="allParcels.php">ALL PARCELS</a></li>
        <li><a href="createparcel.php">CREATE</a></li>
        <li><a href="adminhomepage.php#tracking"">TRACK</a></li>
    </ul>
</div>
<div>
    <?php
    if($result){
        echo  "<div class='successbox'>"
            . "<p>Parcel with ". $trackingNo. " has been deleted successfully</p>"
            ."<p>Please use the navbar to go to the next page you wish to go.</p>"
            ."</div>";

    }
    else{
        die(mysqli_error($connection));
    }
    }
    ?>
</div>

<?php
mysqli_close($connection);
?>
</body>
</html>
