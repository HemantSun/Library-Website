<?php
//we require the configure.php, to use code reuse, this way we dont need to write it one very page
require_once "config.php";

//this is how we use our database connections via a variable
$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error)
{
    die("Connection failed" . $conn->connect_error);
}
?>