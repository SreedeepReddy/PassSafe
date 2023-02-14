<?php
session_start();

$username = $_SESSION["username"];
$hostname = "localhost";
$database = "pass_safe";
$user = "pass_safe_admin";
$pass = "oPjhF0#i3707";
$conn = mysqli_connect($hostname, $user, $pass, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "DELETE FROM sites WHERE user = '$username'";

if (mysqli_query($conn, $sql)) {
    header("location: welcome.php");
} else {
    echo "Error: " .
        $sql .
        "
<br>" .
        mysqli_error($conn);
}

mysqli_close($conn);
?>
