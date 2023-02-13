<?php
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

  // Insert the new user into the database
  $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
  if (mysqli_query($conn, $query)) {
    // Redirect the user to the login page
    header('Location: login.php');
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }

  // Close the connection
  mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registration Page</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <div class="header">
	<img src="http://localhost/PassSafe/Assets/Images/PassSafe_White.png" alt="PassSafe">
  </div>

</head>
<body>
  <div class="container">
    <h1>Register</h1>
    <form action="register.php" method="post">
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