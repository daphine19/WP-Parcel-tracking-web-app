<?php
$username = "s5324600";
$password = "U3nqkgCEuAqhYr4PFaLpJiYAoufwKpHo";
$host = "db.bucomputing.uk";
$port = 6612;
$database = $username;

$connection = mysqli_init();
if (!$connection) {
    echo "<p>Initalising MySQLi failed</p>";
}
else {
    mysqli_ssl_set($connection, NULL, NULL, NULL, '/public_html/sys_tests', NULL);
    mysqli_real_connect($connection, $host, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
    //echo "connection was succesful";
}
if (mysqli_connect_errno()) { // If connection error
    echo "<p>Failed to connect to MySQL. " .
        "Error (" . mysqli_connect_errno() . "): " . mysqli_connect_error() . "</p>";
}
?>
