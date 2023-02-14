<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Connect to the database
    $hostname = "localhost";
    $database = "pass_safe";
    $user = "pass_safe_admin";
    $pass = "oPjhF0#i3707";
    $conn = mysqli_connect($hostname, $user, $pass, $database);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape the incoming data to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $_SESSION["username"] = $username;

    // Check if the username and password exist in the database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // Redirect the user to the welcome page
        header("Location: welcome.php");
    } else {
        // Redirect the user to the register page
        header("Location: register.php");
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-darkmode@1.0.0/dist/bootstrap-darkmode.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-darkmode@1.0.0/dist/bootstrap-darkmode.min.js"></script>
    <div class="header">
      <img src="http://localhost/PassSafe/Assets/Images/PassSafe_White.png" alt="PassSafe">
    </div>
  </head>
  <body>
    <div class="container">
      <h1>Login to PassSafe</h1>
      <form action="login.php" method="post">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </body>
</html>