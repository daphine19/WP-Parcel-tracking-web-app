<?php
include 'connection.php';
include "logincheck.php";

$trackingnumber =  $_GET['updatestatusid'];


if (isset($_POST["updatesystem"])) {
    $status = trim(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));


    // check that non of the fields have been left empty
    if (!empty($status) && !empty($date))
    {
        $query = "UPDATE `Parcels` SET parcelstatus='$status', parceldate ='$date'
                    WHERE TrackingNumber = '$trackingnumber'";
        $result = mysqli_query($connection, $query);
        if ($result==true) {
            echo
                "<div class='successbox'>"
                . "<p>Parcel status has been updated successfully<p>"
                ."<p>Please use the navbar to go to the next page you wish to go.</p>"
            ."</div>";

        }
        else {
            die(mysqli_error($connection));

        }
    }
    else{
        echo "please check all feilds have been filled";
    }
}
?>


<html>
    <head>
        <title>PARCEL CREATE PAGE</title>
        <meta http-equiv="x-ua-compatible" content="IE=100">
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <link rel = "stylesheet" href = "admin.css">
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
            <li><a href = "logout.php">logout</a></li>
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
            <li><a href="adminupdate.php">UPDATE SYSTEM</a></li>
            <li><a href="adminhomepage.php#tracking"">TRACK</a></li>
        </ul>
    </div>
        <div id = "wrapper">
            <form method = "post" action="adminupdate.php?updatestatusid=<?php echo $trackingnumber;?>">
                <label>Delivery status</label><br>
                <select id= "status" name="status">
                    <option value= 'created' name='<?php echo $status;?>'>Created</option>
                    <option value= 'dispatched' name='<?php echo $status;?>'>Dispatched</option>
                    <option value= 'delivered' name='<?php echo $status;?>'>Delivered</option>
                </select><br>
                <label>Date:</label><br>
                <input type = "date" name="date" value='<?php echo $date;?>'><br>
                <input type ="submit" value ="Update" name="updatesystem">
            </form>
        </div>
    </body>
</html>
