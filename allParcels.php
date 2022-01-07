<?php
include 'connection.php';
include "logincheck.php";
?>
<html>
    <head>
        <title>View,update and delete parcels</title>
        <meta http-equiv="x-ua-compatible" content="IE=100">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel = "stylesheet" href = "allParcels.css">
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
            }
            else{
                echo "<li><a href=". "registeredhomepage.php".">HOMEPAGE</a></li>";
            }
            ?>

            <li><a href= #adminfullView>VIEW</a></li>
            <li><a href="createparcel.php">CREATE</a></li>
            <li><a href="registeredhomepage.php">TRACK</a></li>
        </ul>
    </div>
            <div id= "adminfullview">
                <table class="table">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Tracking Number</th>
                        <th>Sender's postcode</th>
                        <th>Recipient's postcode</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // this code is for displaying the data from the database into the table or viewing part details of a parcel.
                    $query = "SELECT * FROM `Parcels` ";
                    $result = mysqli_query($connection, $query);
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $trackingno = $row['TrackingNumber'];
                            $Userid = $row['Userid'];
                            $senderspostcode = $row['senderspostcode'];
                            $recepientpostcode = $row['recepientpostcode'];
                            echo '<tr>
                    <td data-label = "User ID">'.$Userid.'</td>
                    <td data-label = "Tracking Number">'.$trackingno.'</td>
                    <td data-label = "Sender\'s postcode">'.$senderspostcode.'</td>
                    <td data-label = "Recepient\'s postcode">'.$recepientpostcode.'</td>
                    <td data-label = "Status">
                        <button><a href = "fullview.php?viewid='.$trackingno.'" class="status">VIEW ALL DETAILS</a></button>
                        <button><a href = "deleteParcel.php?deleteid='.$trackingno.'"  class="status">DELETE PARCEL</a></button>
                        <button><a href = "adminupdate.php?updatestatusid='.$trackingno.'"  class="status">UPDATE STATUS</a></button>
                        <button><a href = "updateParcel.php?updateparcelid='.$trackingno.'" class="status">UPDATE PARCEL</a></button>
                    </td>
                </tr>';
                        }
                    }
                    ?>
                    </tbody>

                </table>
            </div>
        <?php
        mysqli_close($connection);
        ?>
    </body>
</html>