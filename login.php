<?php
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
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
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $_SESSION['username'] = $username;

  // Check if the username and password exist in the database
  $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    // Redirect the user to the welcome page
    header('Location: welcome.php');
  } else {
    // Redirect the user to the register page
    header('Location: register.php');
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
