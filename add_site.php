<?php
  session_start();

  $hostname = "localhost";
  $database = "pass_safe";
  $user = "pass_safe_admin";
  $pass = "oPjhF0#i3707";
  $conn = mysqli_connect($hostname, $user, $pass, $database);
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $siteName = mysqli_real_escape_string($conn, $_POST['siteName']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "INSERT INTO sites (site_name, password)
          VALUES ('$siteName', '$password')";

  if (mysqli_query($conn, $sql)) {
    header("location: welcome.php");
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
?>