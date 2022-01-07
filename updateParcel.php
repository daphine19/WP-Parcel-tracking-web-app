<?php
include 'connection.php';
include 'logincheck.php';

//get the id when the update button is pressed from the table.
$trackingNo = $_GET['updateparcelid'];

// will help make sure the form is prefilled when one clicks the update button
$query ="SELECT * from `Parcels` where TrackingNumber = '$trackingNo'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$recepientsfullname = $row['recepientfullname'];
$recepientsemail = $row['recepientemailaddress'];
$recepientstelephone = $row['recepienttelephone'];
$recepientspostcode = $row['recepientpostcode'];
$recepientshousenumber = $row['recepienthousenumber'];
$recepientsstreetname = $row['recepientstreetname'];


// will carry out the update query in the database
if (isset($_POST["updateSubmit"])) {

    $recepientsfullname =trim(filter_input(INPUT_POST, 'recepientsfullname', FILTER_SANITIZE_STRING)); 
    $recepientsemail = trim(filter_input(INPUT_POST, 'recepientsemailaddress', FILTER_SANITIZE_STRING));
    $recepientstelephone =trim(filter_input(INPUT_POST, 'recepientstelephone', FILTER_SANITIZE_STRING));
    $recepientspostcode = trim(filter_input(INPUT_POST, 'recepientspostcode', FILTER_SANITIZE_STRING));
    $recepientshousenumber = trim(filter_input(INPUT_POST, 'recepientshousenumber', FILTER_SANITIZE_STRING));
    $recepientsstreetname = trim(filter_input(INPUT_POST, 'recepientsstreetname', FILTER_SANITIZE_STRING));

    // check that non of the fields have been left empty
    //I didnt check idividually in this one because the from will be prefilled.
    if (!empty($recepientsfullname) && !empty($recepientsemail) && !empty($recepientstelephone) && !empty($recepientspostcode)&& !empty($recepientshousenumber) &&!empty($recepientsstreetname))
    {
        $query = "UPDATE `Parcels` set 
                   recepientfullname='$recepientsfullname' ,recepientemailaddress=  '$recepientsemail',recepienttelephone = '$recepientstelephone',
                    recepientpostcode= '$recepientspostcode',recepienthousenumber= '$recepientshousenumber', recepientstreetname= '$recepientsstreetname'
                    where TrackingNumber = '$trackingNo'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            echo "<div class='successbox'>"
                . "<p>Thank you for updating your parcel with ParcelGo.</p>"."<br>"
                ."<p>You can now view the changed details in your parcels table.</p>"
                ."</div>"
            ;
        }
        else {
            die(mysqli_error($connection));
            echo "Update parcel failed please try again.";

        }
    }
    else{
        echo "Please fill in all the fields";
    }
}
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
        //this code helps redirect to the correct homepage according to the user logged in.
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
    <form action="updateParcel.php?updateparcelid=<?php echo $trackingNo;?>" class="form" method="post">

        <!--actual form -->
        <div class = "category">
            <h3 class = "headings">RECIPIENT'S DETAILS</h3>
            <h4>Contact information</h4>
            <label>Fullname</label><br>
            <input type = "text" name="recepientsfullname" value='<?php echo $recepientsfullname; ?>'> <br>
            <label>Email address </label><br>
            <input type = "email"  name="recepientsemailaddress"value= '<?php echo $recepientsemail; ?>'> <br>
            <label>Telephone </label><br>
            <input type = "tel"  name="recepientstelephone" value= '<?php echo $recepientstelephone; ?>'> <br>

            <h4>Address details </h4>
            <label>PostCode </label><br>
            <input type = "text" name="recepientspostcode" value= '<?php echo $recepientspostcode; ?>'><br>
            <label>House Number </label><br>
            <input type = "number" name="recepientshousenumber" value= '<?php echo $recepientshousenumber; ?>'><br>
            <label>Street name </label><br>
            <input type = "text"  name="recepientsstreetname" value= '<?php echo $recepientsstreetname; ?>'><br>
            <button name= updateSubmit type="submit" class="button">Update</button>
        </div>
    </form>
</div>
<?php
mysqli_close($connection);
?>
</body>
</html>

