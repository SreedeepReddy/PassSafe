<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: welcome.php');
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome Page</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <div class="header">
	<img src="http://localhost/PassSafe/Assets/Images/PassSafe_White.png" alt="PassSafe">
  </div>
  <script type="text/javascript">
    function validateForm() {
      var siteName = document.forms["addSiteForm"]["siteName"].value;
      var password = document.forms["addSiteForm"]["password"].value;
      if (siteName == "" || password == "") {
        alert("Site name and password must be filled out");
        return false;
      }
    }
	function togglePasswordVisibility(id) {
      var x = document.getElementById(id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo $username; ?>!</h1>
	<h1>Here are your saved passwords</h1>
	<table>
      <tr>
        <th>Site Name</th>
        <th>Password</th>
      </tr>
      <?php
        $hostname = "localhost";
		$database = "pass_safe";
		$user = "pass_safe_admin";
		$pass = "oPjhF0#i3707";
		$conn = mysqli_connect($hostname, $user, $pass, $database);
        // Check connection
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT site_name, password FROM sites";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          // Output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["site_name"]. "</td><td><input type='password' id='password_" . $row['site_name'] . "' value='" . $row['password'] . "'><label for='password_" . $row['site_name'] . "'><span onclick='togglePasswordVisibility(\"password_" . $row['site_name'] . "\")'>Show/Hide</span></label></td></tr>";
          }
        } else {
          echo "<tr><td colspan='2'>No saved sites found</td></tr>";
        }

        mysqli_close($conn);
      ?>
    </table>
    <h2>Add a new site</h2>
    <form name="addSiteForm" action="add_site.php" onsubmit="return validateForm()" method="post">
      <div class="form-group">
        <label for="siteName">Site Name:</label>
        <input type="text" id="siteName" name="siteName">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
      </div>
      <button type="submit">Add Site</button>
    </form>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
